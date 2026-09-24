<?php

namespace App\Services;

use App\Models\StatistiqueGeo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Géolocalise une adresse IP (pays, région, ville) via ip-api.com
 * (service gratuit sans clé). Chaque résultat est mis en cache par IP
 * dans la table statistiques_geo pour éviter un appel externe à chaque page.
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

        $cache = StatistiqueGeo::find($ip);
        if ($cache) {
            return [
                'pays' => $cache->pays,
                'pays_code' => $cache->pays_code,
                'region' => $cache->region,
                'ville' => $cache->ville,
            ];
        }

        $geo = $this->chercher($ip);

        StatistiqueGeo::updateOrCreate(['ip' => $ip], array_merge($geo, ['recherche_a' => now()]));

        return $geo;
    }

    /**
     * Localisation du réseau local = géolocalisation de l'IP publique du serveur,
     * mise en cache (la position change rarement).
     */
    private function localisationDuReseauLocal(): array
    {
        $cache = Cache::get('statistiques.localisation_reseau');
        if (is_array($cache)) {
            return $cache;
        }

        try {
            $reponse = Http::timeout(3)->get('http://ip-api.com/json/', [
                'fields' => 'status,country,countryCode,regionName,city',
                'lang' => 'fr',
            ]);

            $donnees = $reponse->json();

            if ($reponse->ok() && ($donnees['status'] ?? '') === 'success') {
                $geo = [
                    'pays' => $donnees['country'] ?? null,
                    'pays_code' => $donnees['countryCode'] ?? null,
                    'region' => $donnees['regionName'] ?? null,
                    'ville' => $donnees['city'] ?? null,
                ];

                Cache::put('statistiques.localisation_reseau', $geo, now()->addDays(7));

                return $geo;
            }
        } catch (\Throwable) {
            // Machine hors ligne ou service indisponible : on retombe sur
            // une localisation indéterminée.
        }

        return ['pays' => null, 'pays_code' => null, 'region' => null, 'ville' => null];
    }

    private function chercher(string $ip): array
    {
        try {
            $reponse = Http::timeout(2)->get('http://ip-api.com/json/' . $ip, [
                'fields' => 'status,country,countryCode,regionName,city',
                'lang' => 'fr',
            ]);

            $donnees = $reponse->json();

            if ($reponse->ok() && ($donnees['status'] ?? '') === 'success') {
                return [
                    'pays' => $donnees['country'] ?? null,
                    'pays_code' => $donnees['countryCode'] ?? null,
                    'region' => $donnees['regionName'] ?? null,
                    'ville' => $donnees['city'] ?? null,
                ];
            }
        } catch (\Throwable) {
            // Service de géolocalisation indisponible : on retombe sur « Non déterminé ».
        }

        return ['pays' => null, 'pays_code' => null, 'region' => null, 'ville' => null];
    }
}