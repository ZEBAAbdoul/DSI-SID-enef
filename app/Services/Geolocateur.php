<?php

namespace App\Services;

use App\Models\StatistiqueGeo;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Géolocalise une adresse IP (pays, région, ville) pour les statistiques de
 * fréquentation. Plusieurs fournisseurs gratuits sans clé sont interrogés en
 * parallèle (freeipapi.com, ipwhois.app, ip-api.com) et la ville retenue est
 * celle qui recueille le plus de voix : certaines bases grossières « épinglent »
 * les IP mobiles sur la capitale (ex. une IP Orange Burkina est résolue
 * « Ouagadougou » par ip-api alors que sa position réelle est ailleurs,
 * p. ex. « Bobo-Dioulasso »). Deux fournisseurs qui s'accordent sur une
 * autre ville l'emportent donc sur le seul fournisseur qui répond la capitale.
 * En cas d'égalité, freeipapi.com (le plus précis sur ces IP) départage.
 *
 * Chaque résultat est mis en cache par IP dans la table statistiques_geo pour
 * éviter des appels externes à chaque page. La fraîcheur du cache est réglable
 * (config/statistiques.php) : la position est re-recherchée dès qu'elle est
 * périmée, pour rester en temps réel.
 */
class Geolocateur
{
    public function pour(string $ip): array
    {
        // IP privée / locale (localhost, LAN, intranet…) : la géolocalisation
        // publique ne connaît pas ces adresses. On utilise alors la localisation
        // du réseau local, estimée par l'IP publique du serveur (même lieu
        // physique que les machines connectées au LAN).
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $this->localisationDuReseauLocal();
        }

        $ttl = (int) config('statistiques.geo_ttl_secondes', 300);
        $cache = StatistiqueGeo::find($ip);

        // Cache encore frais (sous le TTL) : position connue renvoyée telle quelle.
        if ($cache && $cache->recherche_a !== null && $cache->recherche_a->gte(now()->subSeconds($ttl))) {
            return [
                'pays' => $cache->pays,
                'pays_code' => $cache->pays_code,
                'region' => $cache->region,
                'ville' => $cache->ville,
            ];
        }

        $geo = $this->chercher($ip);

        // On ne persiste pas une résolution vide (fournisseurs indisponibles) :
        // la prochaine visite retentera plutôt que d'afficher « — » pendant 5 min.
        if ($geo['pays'] !== null || $geo['ville'] !== null) {
            StatistiqueGeo::updateOrCreate(['ip' => $ip], array_merge($geo, ['recherche_a' => now()]));
        }

        return $geo;
    }

    /**
     * Localisation du réseau local = géolocalisation de l'IP publique du serveur.
     * Mise en cache courte (fraîcheur réglable) pour rester en temps réel.
     */
    private function localisationDuReseauLocal(): array
    {
        $cache = Cache::get('statistiques.localisation_reseau');
        if (is_array($cache) && ($cache['pays'] ?? null) !== null) {
            return $cache;
        }

        $geo = $this->chercher(null); // IP publique du serveur (appelant)

        $ttl = (int) config('statistiques.geo_ttl_secondes', 300);
        if (($geo['pays'] ?? null) !== null) {
            Cache::put('statistiques.localisation_reseau', $geo, now()->addSeconds($ttl));
        }

        return $geo;
    }

    /**
     * Vérification croisée : interroge les fournisseurs en parallèle (ne
     * pénalise pas le temps de réponse de la page), puis retient la ville qui
     * recueille le plus de voix. En cas d'égalité, l'ordre de la liste
     * (freeipapi.com d'abord) départage. Avec $ip = null, on géolocalise
     * l'IP publique de l'appelant (utilisé pour le réseau local).
     */
    private function chercher(?string $ip): array
    {
        $fournisseurs = $this->fournisseurs($ip);

        $reponses = Http::pool(function (Pool $pool) use ($fournisseurs): array {
            $requetes = [];
            foreach ($fournisseurs as $cle => $fournisseur) {
                $requetes[$cle] = $pool->as((string) $cle)
                    ->timeout(4)
                    ->withOptions($this->optionsTls())
                    ->get($fournisseur['url'], $fournisseur['params'] ?? []);
            }

            return $requetes;
        });

        // Vote par ville normalisée : chaque fournisseur valide apporte une voix,
        // la première occurrence garde les libellés (pays, région) à enregistrer.
        $voix = [];
        foreach ($fournisseurs as $cle => $fournisseur) {
            $reponse = $reponses[$cle] ?? null;
            if (! $reponse instanceof Response || $reponse->failed()) {
                continue; // Fournisseur indisponible ou réponse en erreur.
            }

            try {
                $geo = $fournisseur['carte']($reponse->json(), $reponse->ok());
            } catch (\Throwable) {
                $geo = null;
            }
            if ($geo === null || ! $geo['ville']) {
                continue;
            }

            $cleVille = mb_strtolower(trim($geo['ville']));
            if (! isset($voix[$cleVille])) {
                $geo['__voix'] = 0;
                $voix[$cleVille] = $geo;
            }
            $voix[$cleVille]['__voix']++;
        }

        if ($voix === []) {
            return ['pays' => null, 'pays_code' => null, 'region' => null, 'ville' => null];
        }

        // La ville la plus votée gagne ; l'égalité est départagée par l'ordre
        // d'insertion (freeipapi.com en premier) — tri stable en PHP 8.
        uasort($voix, fn (array $a, array $b): int => ($b['__voix'] ?? 0) <=> ($a['__voix'] ?? 0));
        $gagnante = array_key_first($voix);
        unset($voix[$gagnante]['__voix']);

        return $voix[$gagnante];
    }

    /**
     * Options TLS pour les appels HTTPS : sur les machines Windows où le
     * bundle CA de référence n'est pas configuré dans php.ini, on fournit
     * explicitement le bundle de cURL (storage/app/certs/cacert.pem) pour
     * pouvoir vérifier les certificats des fournisseurs HTTPS.
     */
    private function optionsTls(): array
    {
        $bundle = storage_path('app/certs/cacert.pem');

        return is_file($bundle) ? ['verify' => $bundle] : [];
    }

    /**
     * @return array<int, array{url: string, params: array, carte: callable}>
     */
    private function fournisseurs(?string $ip): array
    {
        $url = fn (string $chemin): string => $ip === null ? $chemin : $chemin . $ip;

        return [
            // freeipapi.com : base plus précise sur les IP mobiles africaines
            // (ex. une IP Orange Burkina est résolue « Bobo-Dioulasso » et non
            // épinglée sur la capitale). HTTPS, gratuit sans clé.
            [
                'url' => $url('https://freeipapi.com/api/json/'),
                'params' => [],
                'carte' => function (array $donnees, bool $ok): ?array {
                    if (! $ok || empty($donnees['ipAddress'])) {
                        return null;
                    }

                    return [
                        'pays' => $donnees['countryName'] ?? null,
                        'pays_code' => $donnees['countryCode'] ?? null,
                        'region' => $donnees['regionName'] ?? null,
                        'ville' => $donnees['cityName'] ?? null,
                    ];
                },
            ],
            // ipwhois.app : second fournisseur précis (HTTPS, gratuit sans clé).
            [
                'url' => $url('https://ipwhois.app/json/'),
                'params' => [],
                'carte' => function (array $donnees, bool $ok): ?array {
                    if (! $ok || empty($donnees['success'])) {
                        return null;
                    }

                    return [
                        'pays' => $donnees['country'] ?? null,
                        'pays_code' => $donnees['country_code'] ?? null,
                        'region' => $donnees['region'] ?? null,
                        'ville' => $donnees['city'] ?? null,
                    ];
                },
            ],
            // ip-api.com : dernier recours (limites 45 req/min, base grossière
            // sur les IP mobiles africaines). Noms de pays/régions en français.
            [
                'url' => $url('http://ip-api.com/json/'),
                'params' => ['fields' => 'status,country,countryCode,regionName,city', 'lang' => 'fr'],
                'carte' => function (array $donnees, bool $ok): ?array {
                    if (! $ok || ($donnees['status'] ?? '') !== 'success') {
                        return null;
                    }

                    return [
                        'pays' => $donnees['country'] ?? null,
                        'pays_code' => $donnees['countryCode'] ?? null,
                        'region' => $donnees['regionName'] ?? null,
                        'ville' => $donnees['city'] ?? null,
                    ];
                },
            ],
        ];
    }
}