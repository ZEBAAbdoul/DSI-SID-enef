<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\FormationInformation;

class CatalogueController extends Controller
{
    private const CAT_PROGRAMMEE = 'formation-programmee';
    private const CAT_A_LA_CARTE = 'formation-a-la-carte';
    private const CAT_INITIALE   = 'formation-initiale';

    public function index()
    {
        $formationsProgrammees = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_PROGRAMMEE);
            })
            ->orderBy('code_module')
            ->with(['sessions' => function ($q) {
                $q->where('date_debut', '>=', now())->orderBy('date_debut');
            }])
            ->get();

        $formationsALaCarte = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_A_LA_CARTE);
            })
            ->orderBy('code_module')
            ->get();

        $formationsInitiales = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_INITIALE);
            })
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
        $formationsProgrammees = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_PROGRAMMEE);
            })
            ->orderBy('code_module')
            ->with(['sessions' => function ($q) {
                $q->where('date_debut', '>=', now())->orderBy('date_debut');
            }])
            ->get();

        $formationsALaCarte = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_A_LA_CARTE);
            })
            ->orderBy('code_module')
            ->get();

        $formationsInitiales = Formation::whereHas('categorie', function ($q) {
                $q->where('slug', self::CAT_INITIALE);
            })
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