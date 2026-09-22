<?php

namespace App\Http\Controllers;

use App\Models\FormationInformation;

class InformationsComplementairesController extends Controller
{
    public function index()
    {;
        $informations = FormationInformation::orderBy('ordre')->get()->groupBy('categorie');

        return view('formations.informations-complementaires', [
            'frais' => $informations->get('frais', collect()),
            'paiementIntermediaire' => $informations->get('paiement_intermediaire', collect()),
            'paiementTerminale' => $informations->get('paiement_terminale', collect()),
            'dossier' => $informations->get('dossier', collect()),
        ]);
    }
}