<?php

// app/Http/Controllers/UserActivationController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserActivationController extends Controller
{
    /**
     * Active / désactive un compte.
     * Répond en JSON pour l'interrupteur AJAX du tableau, et par une redirection sinon.
     */
    public function toggle(Request $request, User $user)
    {
        // On ne peut pas se désactiver soi-même (risque de se verrouiller hors de l'application)
        if ($user->is($request->user())) {
            $message = 'Vous ne pouvez pas désactiver votre propre compte.';

            return $request->expectsJson()
                ? response()->json(['message' => $message], 422)
                : back()->with('error', $message);
        }

        $user->est_actif = ! $user->est_actif;
        $user->save();

        $message = $user->est_actif
            ? 'Le compte a été activé.'
            : "Le compte a été désactivé : l'utilisateur ne peut plus se connecter.";

        return $request->expectsJson()
            ? response()->json(['est_actif' => $user->est_actif, 'message' => $message])
            : back()->with('success', $message);
    }
}
