<?php

namespace App\Http\Controllers;

use App\Models\Formation;

class CatalogueController extends Controller
{
    /**
     * Affiche le catalogue complet de formations (programmées + à la carte)
     * tel qu'ouvert depuis le bouton "Découvrir le catalogue de formations".
     */
    public function index()
    {
        $formationsProgrammees = Formation::where('type', 'continue_programmee')
            ->orderBy('code_module')
            ->with(['sessions' => function ($q) {
                $q->where('date_debut', '>=', now())->orderBy('date_debut');
            }])
            ->get();

        $formationsALaCarte = Formation::where('type', 'continue_a_la_carte')
            ->orderBy('code_module')
            ->get();

        $formationsInitiales = Formation::whereNotIn('type', ['continue_programmee', 'continue_a_la_carte'])
            ->orderByRaw("CASE WHEN code_module LIKE 'FI-GRN%' THEN 0 ELSE 1 END")
            ->orderBy('code_module')
            ->get();

        return view('formations.catalogue', [
            'formationsProgrammees' => $formationsProgrammees,
            'formationsALaCarte' => $formationsALaCarte,
            'formationsInitiales' => $formationsInitiales,
        ]);
    }

    public function formationContinue()
    {
        $formationsProgrammees = Formation::where('type', 'continue_programmee')
            ->orderBy('code_module')
            ->with(['sessions' => function ($q) {
                $q->where('date_debut', '>=', now())->orderBy('date_debut');
            }])
            ->get();

        $formationsALaCarte = Formation::where('type', 'continue_a_la_carte')
            ->orderBy('code_module')
            ->get();

        $formationsInitiales = Formation::whereNotIn('type', ['continue_programmee', 'continue_a_la_carte'])
            ->orderByRaw("CASE WHEN code_module LIKE 'FI-GRN%' THEN 0 ELSE 1 END")
            ->orderBy('code_module')
            ->get();

        return view('formations.Catalogue_formation_continue', [
            'formationsProgrammees' => $formationsProgrammees,
            'formationsALaCarte' => $formationsALaCarte,
            'formationsInitiales' => $formationsInitiales,
        ]);
    }
}
