<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoAdminController extends Controller
{
    /**
     * Liste des vidéos.
     */
    public function index(Request $request)
    {
        $query = Video::query();

        // Recherche
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;

            $query->where(function ($q) use ($recherche) {
                $q->where('titre', 'ILIKE', '%' . $recherche . '%')
                    ->orWhere('description', 'ILIKE', '%' . $recherche . '%')
                    ->orWhere('url', 'ILIKE', '%' . $recherche . '%');
            });
        }

        $videos = $query
            ->orderBy('ordre', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Enregistrer une vidéo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:2048',
            'ordre' => 'nullable|integer|min:0',
            'est_visible' => 'nullable|boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'url.required' => 'Le lien de la vidéo est obligatoire.',
            'url.url' => 'Le lien de la vidéo doit être une URL valide.',
            'url.max' => 'Le lien de la vidéo est trop long.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre ne peut pas être négatif.',
        ]);

        Video::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'],
            'ordre' => $validated['ordre'] ?? 0,
            'est_visible' => $request->boolean('est_visible', true),
        ]);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'La vidéo a été ajoutée avec succès.');
    }

    /**
     * Afficher une vidéo.
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Mettre à jour une vidéo.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url|max:2048',
            'ordre' => 'nullable|integer|min:0',
            'est_visible' => 'nullable|boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'url.required' => 'Le lien de la vidéo est obligatoire.',
            'url.url' => 'Le lien de la vidéo doit être une URL valide.',
            'url.max' => 'Le lien de la vidéo est trop long.',
            'ordre.integer' => 'L\'ordre doit être un nombre entier.',
            'ordre.min' => 'L\'ordre ne peut pas être négatif.',
        ]);

        $video->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'],
            'ordre' => $validated['ordre'] ?? 0,
            'est_visible' => $request->boolean('est_visible', false),
        ]);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'La vidéo a été modifiée avec succès.');
    }

    /**
     * Supprimer une vidéo.
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'La vidéo a été supprimée avec succès.');
    }
}

