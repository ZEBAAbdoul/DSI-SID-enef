<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\FormationInformation;

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
    ->orderBy('created_at')
    ->orderBy('id')
    ->get();

        $informations = FormationInformation::orderBy('ordre')->get()->groupBy('categorie');


        return view('formations.catalogue', [
            'formationsProgrammees' => $formationsProgrammees,
            'formationsALaCarte' => $formationsALaCarte,
            'formationsInitiales' => $formationsInitiales,

            'frais' => $informations->get('frais', collect()),
            'paiementIntermediaire' => $informations->get('paiement_intermediaire', collect()),
            'paiementTerminale' => $informations->get('paiement_terminale', collect()),
            'dossier' => $informations->get('dossier', collect()),
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

        $informations = FormationInformation::orderBy('ordre')->get()->groupBy('categorie');


        return view('formations.Catalogue_formation_continue', [
            'formationsProgrammees' => $formationsProgrammees,
            'formationsALaCarte' => $formationsALaCarte,
            'formationsInitiales' => $formationsInitiales,

            'frais' => $informations->get('frais', collect()),
            'paiementIntermediaire' => $informations->get('paiement_intermediaire', collect()),
            'paiementTerminale' => $informations->get('paiement_terminale', collect()),
            'dossier' => $informations->get('dossier', collect()),
        ]);
    }
}
