<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBackoffice
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(
            $request->user()?->hasAnyRole(['user', 'enseignant']),
            403,
            "Accès réservé à l'administration."
        );

        return $next($request);
    }
}