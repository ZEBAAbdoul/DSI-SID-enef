<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoPublicController extends Controller
{
    /**
     * Galerie photo & vidéo publique (uniquement les médias visibles).
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request): View
    {
        $photos = Photo::where('est_visible', true)
            ->orderBy('ordre', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $videos = Video::where('est_visible', true)
            ->orderBy('ordre', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Onglet actif : ?type=videos ouvre directement l'onglet Vidéos
        $type = $request->query('type') === 'videos' ? 'videos' : 'photos';

        return view('galerie.index', compact('photos', 'videos', 'type'));
    }
}