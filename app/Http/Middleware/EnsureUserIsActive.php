<?php

// app/Http/Middleware/EnsureUserIsActive.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Déconnecte immédiatement un utilisateur déjà connecté dont le compte vient d'être désactivé
 * (sans ça, il resterait connecté jusqu'à l'expiration de sa session ou de son "remember me").
 */
class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->est_actif) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['email' => "Votre compte a été désactivé. Veuillez contacter l'administration."]);
        }

        return $next($request);
    }
}