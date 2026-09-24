<?php

namespace App\Http\Controllers;

use App\Models\RechercheInnovation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RechercheInnovationPublicController extends Controller
{
    /**
     * Liste des recherches et innovations publiées (pagination à 9 par page),
     * filtrable par type via ?type=recherche ou ?type=innovation.
     */
    public function index(Request $request): View
    {
        $recherchesInnovations = RechercheInnovation::publiees()
            ->deType($request->query('type'))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $types = [
            'recherche'  => 'Recherche',
            'innovation' => 'Innovation',
        ];

        return view(
            'recherches_innovations.index',
            compact('recherchesInnovations', 'types')
        );
    }

    /**
     * Afficher une recherche ou une innovation publiée via son slug.
     */
    public function show(RechercheInnovation $recherches_innovation): View
    {
        return view(
            'recherches_innovations.show',
            ['rechercheInnovation' => $recherches_innovation]
        );
    }
}