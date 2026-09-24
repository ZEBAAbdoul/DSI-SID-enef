<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActualitePublicController extends Controller
{
    /**
     * Liste des actualités publiées (pagination à 10 par page).
     */
    public function index(Request $request): View
    {
        $actualites = Actualite::publiees()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('actualites.index', compact('actualites'));
    }

    /**
     * Afficher une actualité publiée via son slug.
     */
    public function show(Actualite $actualite): View
    {
        return view('actualites.show', compact('actualite'));
    }
}