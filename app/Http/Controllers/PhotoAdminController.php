<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoAdminController extends Controller
{
    /**
     * Afficher la liste des photos.
     */
    public function index()
    {
       $photos = Photo::orderBy('ordre', 'asc')
    ->orderBy('created_at', 'desc')
    ->paginate(10);

        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Enregistrer une nouvelle photo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordre' => 'nullable|integer|min:0',
            'est_visible' => 'nullable|boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5 Mo.',
        ]);

        // Upload de l'image
        $imagePath = $request->file('image')->store('photos', 'public');

        Photo::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imagePath,
            'ordre' => $validated['ordre'] ?? 0,
            'est_visible' => $request->boolean('est_visible', true),
        ]);

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'La photo a été ajoutée avec succès.');
    }

    /**
     * Afficher une photo.
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Mettre à jour une photo.
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ordre' => 'nullable|integer|min:0',
            'est_visible' => 'nullable|boolean',
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.',
            'image.max' => 'L\'image ne doit pas dépasser 5 Mo.',
        ]);

        // Si une nouvelle image est envoyée
        if ($request->hasFile('image')) {

            // Supprimer l'ancienne image
            if ($photo->image_url && Storage::disk('public')->exists($photo->image_url)) {
                Storage::disk('public')->delete($photo->image_url);
            }

            // Enregistrer la nouvelle image
            $imagePath = $request->file('image')->store('photos', 'public');

            $photo->image_url = $imagePath;
        }

        $photo->titre = $validated['titre'];
        $photo->description = $validated['description'] ?? null;
        $photo->ordre = $validated['ordre'] ?? 0;
        $photo->est_visible = $request->boolean('est_visible', false);

        $photo->save();

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'La photo a été modifiée avec succès.');
    }

    /**
     * Supprimer une photo.
     */
    public function destroy(Photo $photo)
    {
        // Supprimer le fichier image
        if ($photo->image_url && Storage::disk('public')->exists($photo->image_url)) {
            Storage::disk('public')->delete($photo->image_url);
        }

        $photo->delete();

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'La photo a été supprimée avec succès.');
    }
}
