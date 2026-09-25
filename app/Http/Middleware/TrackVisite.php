<?php

namespace App\Http\Middleware;

use App\Models\Visite;
use App\Services\Geolocateur;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Enregistre les visites du site public : page visitée, adresse IP (lieu déduit),
 * session (hachée). Une ligne = une page vue.
 *
 * L'administration, l'API, les assets, les pages d'authentification,
 * les requêtes AJAX et les non-GET sont ignorés.
 */
class TrackVisite
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->doitIgnorer($request, $response)) {
            return $response;
        }

        // La statistique ne doit jamais faire tomber le site.
        try {
            $this->enregistrer($request, $response);
        } catch (\Throwable $e) {
            report($e);
        }

        return $response;
    }

    private function enregistrer(Request $request, Response $response): void
    {
        $ip = $request->ip() ?? '0.0.0.0';

        // Requête locale (localhost / LAN) : l'IP vue par le serveur est privée
        // et ne décrit pas le lieu du visiteur. Si le navigateur a révélé son
        // IP publique (cookie enef_ip_pub posé par les pages du site), on
        // géolocalise cette IP plutôt que le réseau local du serveur.
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            $ipPublique = $request->cookie('enef_ip_pub');
            if (is_string($ipPublique) && $ipPublique !== ''
                && filter_var($ipPublique, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $ip = $ipPublique;
            }
        }

        $session = substr(hash('sha256', (string) $request->session()->getId()), 0, 32);
        $visiteur = $this->visiteur($request, $response, $session);

        $geo = app(Geolocateur::class)->pour($ip);

        Visite::create([
            'visite_a' => now(),
            'date' => now()->toDateString(),
            'page' => $request->path() ?: '/',
            'session_id' => $session,
            'visiteur' => $visiteur,
            'ip' => $ip,
            'pays' => $geo['pays'],
            'pays_code' => $geo['pays_code'],
            'region' => $geo['region'],
            'ville' => $geo['ville'],
        ]);
    }

    /**
     * Identifiant stable du visiteur : le cookie enef_visiteur est posé dès la
     * première page publique et survit à la régénération de session (connexion /
     * déconnexion de l'administration). Sans cookie (refusé par le navigateur),
     * on retombe sur l'identité de session : comportement d'avant, sans inflation.
     */
    private function visiteur(Request $request, Response $response, string $session): string
    {
        $present = $request->cookie('enef_visiteur');
        if (is_string($present) && preg_match('/^[A-Za-z0-9-]{20,64}$/', $present)) {
            return $present;
        }

        // Première visite (ou cookie refusé) : on garde l'identité de la session
        // et on la prolonge par cookie pour les prochaines visites (le cookie
        // n'étant pas encrypté, il est lisible par ce middleware).
        $response->headers->setCookie(
            cookie('enef_visiteur', $session, 525600, '/', null, false, true, false, 'lax')
        );

        return $session;
    }

    private function doitIgnorer(Request $request, Response $response): bool
    {
        if ($request->method() !== 'GET') {
            return true;
        }

        // On ne compte que les pages correctement rendues.
        if ($response->getStatusCode() !== 200) {
            return true;
        }

        if ($request->expectsJson()) {
            return true;
        }

        // Zone admin, API et données statiques.
        if (
            $request->is('admin/*')
            || $request->is('api/*')
            || str_starts_with($request->path(), 'storage/')
        ) {
            return true;
        }

        // Pages d'authentification (publiques mais non « de contenu »).
        if ($request->is(
            'login',
            'register',
            'forgot-password',
            'reset-password',
            'reset-password/*',
            'verify-email',
            'verify-email/*',
            'confirm-password'
        )) {
            return true;
        }

        // Fichiers statiques (assets).
        if (preg_match('/\.(css|js|png|jpe?g|gif|svg|webp|ico|woff2?|ttf|eot|pdf|zip|map|json)$/i', $request->path())) {
            return true;
        }

        return false;
    }
}