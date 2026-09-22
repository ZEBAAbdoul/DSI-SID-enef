<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class VideoPublicController extends Controller
{
    /**
     * La galerie photo & vidéo est désormais une rubrique unique.
     * On redirige les anciens liens /videos vers l'onglet Vidéos.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('galerie.index', ['type' => 'videos']);
    }
}