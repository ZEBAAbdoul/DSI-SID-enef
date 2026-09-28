<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InformationConsultationController extends Controller
{
    public function index(): View
    {
        $informations = Information::pourUtilisateur(auth()->user())
            ->orderByDesc('publie_le')
            ->paginate(10);

        return view('admin.informations.consulter', compact('informations'));
    }

    public function telecharger(Information $information)
    {
        $user = auth()->user();

        // Les gestionnaires peuvent tout télécharger, les autres seulement leurs informations
        abort_unless(
            ! $user->hasRole('user') && ! $user->hasRole('enseignant')
                || $information->estVisiblePar($user),
            403
        );

        abort_unless(
            $information->fichier_path && Storage::exists($information->fichier_path),
            404
        );

        return Storage::download($information->fichier_path, $information->fichier_nom);
    }
}