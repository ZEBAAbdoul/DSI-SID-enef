<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\View\View;

class PhotoPublicController extends Controller
{
    /**
     * Affiche la galerie photo publique (uniquement les photos visibles).
     */
    public function index(): View
    {
        $photos = Photo::where('est_visible', true)
            ->orderBy('ordre')
            ->get();

        return view('galerie.index', compact('photos'));
    }
}