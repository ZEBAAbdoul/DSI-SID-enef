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
            $this->enregistrer($request);
        } catch (\Throwable $e) {
            report($e);
        }

        return $response;
    }

    private function enregistrer(Request $request): void
    {
        $ip = $request->ip() ?? '0.0.0.0';
        $geo = app(Geolocateur::class)->pour($ip);

        Visite::create([
            'visite_a' => now(),
            'date' => now()->toDateString(),
            'page' => $request->path() ?: '/',
            'session_id' => substr(hash('sha256', (string) $request->session()->getId()), 0, 32),
            'ip' => $ip,
            'pays' => $geo['pays'],
            'pays_code' => $geo['pays_code'],
            'region' => $geo['region'],
            'ville' => $geo['ville'],
        ]);
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