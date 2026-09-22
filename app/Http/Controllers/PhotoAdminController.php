<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PhotoAdminController extends Controller
{
    /**
     * Afficher la liste des photos.
     */
    public function index(): View
    {
        $photos = Photo::orderBy('ordre', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Afficher le formulaire d'ajout.
     */
    public function create(): View
    {
        return view('admin.photos.create', [
            'prochainOrdre' => (Photo::max('ordre') ?? 0) + 1,
        ]);
    }

    /**
     * Enregistrer une nouvelle photo.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePhoto($request);

        // Prochain numéro d'ordre automatique
        $validated['ordre'] = (Photo::max('ordre') ?? 0) + 1;

        // Upload de l'image vers public/photos (servie via /photos/...)
        $imagePath = $this->sauvegarderImagePublique(
            $request->file('image')
        );

        Photo::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'image_url' => $imagePath,
            'ordre' => $validated['ordre'],
            'est_visible' => $request->boolean('est_visible', true),
        ]);

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'La photo a été ajoutée avec succès.');
    }

    /**
     * Afficher une photo.
     */
    public function show(Photo $photo): View
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Photo $photo): View
    {
        return view('admin.photos.edit', compact('photo'));
    }

    /**
     * Mettre à jour une photo.
     */
public function update(Request $request, Photo $photo): RedirectResponse
{
    $validated = $this->validatePhoto(
        $request,
        $photo->id
    );

    $newOrdre = (int) $request->input(
        'ordre',
        $photo->ordre
    );

    // Vérification de l'ordre
    if ($newOrdre < 0 || $newOrdre > 32767) {
        return back()
            ->withErrors([
                'ordre' => "L'ordre doit être entre 0 et 32767."
            ])
            ->withInput();
    }

    /*
     * Gestion du changement d'ordre
     */
    if ($newOrdre !== $photo->ordre) {

        $conflict = Photo::where('id', '!=', $photo->id)
            ->where('ordre', $newOrdre)
            ->first();

        /*
         * Un conflit existe :
         * demander confirmation à l'utilisateur.
         */
        if ($conflict && !$request->boolean('confirmer_echange')) {

            return back()
                ->withInput()
                ->with('warning_echange', [
                    'message' =>
                        "L'ordre « {$newOrdre} » est déjà utilisé par « {$conflict->titre} ».",

                    'conflict_id' => $conflict->id,

                    'conflict_titre' => $conflict->titre,

                    'new_ordre' => $newOrdre,

                    'current_ordre' => $photo->ordre,
                ]);
        }

        /*
         * Échange des ordres
         */
        if ($conflict) {

            $ancienOrdre = $photo->ordre;

            $tmpOrdre = (Photo::max('ordre') ?? 0) + 5000;

            // Libérer temporairement l'ordre
            $conflict->update([
                'ordre' => $tmpOrdre
            ]);

            // Nouvelle position de la photo
            $photo->update([
                'ordre' => $newOrdre
            ]);

            // Ancienne position de la photo
            $conflict->update([
                'ordre' => $ancienOrdre
            ]);

        } else {

            // Aucun conflit
            $validated['ordre'] = $newOrdre;
        }
    }

    /*
     * Nouvelle image
     */
    if ($request->hasFile('image')) {

        $this->supprimerImagePublique($photo->image_url);

        $validated['image_url'] = $this->sauvegarderImagePublique(
            $request->file('image')
        );
    }

    /*
     * Visibilité
     */
    $validated['est_visible'] =
        $request->boolean('est_visible', false);

    /*
     * Si un échange a déjà été effectué,
     * on ne réécrit pas l'ordre.
     */
    if (
        isset($conflict) &&
        $conflict
    ) {
        unset($validated['ordre']);
    }

    $photo->update($validated);

    return redirect()
        ->route('admin.photos.index')
        ->with(
            'success',
            'La photo a été modifiée avec succès.'
        );
}


    // public function update(Request $request, Photo $photo): RedirectResponse
    // {
    //     $validated = $this->validatePhoto(
    //         $request,
    //         $photo->id
    //     );

    //     $newOrdre = (int) $request->input('ordre', $photo->ordre);

    //     // Vérification de la plage
    //     if ($newOrdre < 0 || $newOrdre > 32767) {
    //         return back()
    //             ->withErrors([
    //                 'ordre' => "L'ordre doit être entre 0 et 32767."
    //             ])
    //             ->withInput();
    //     }

    //     /*
    //      * Gestion du changement d'ordre
    //      */
    //     if ($newOrdre !== $photo->ordre) {

    //         $conflict = Photo::where('id', '!=', $photo->id)
    //             ->where('ordre', $newOrdre)
    //             ->first();

    //         /*
    //          * Un autre photo utilise déjà cet ordre.
    //          * On demande confirmation avant de faire l'échange.
    //          */
    //         if ($conflict && !$request->boolean('confirmer_echange')) {

    //             return back()
    //                 ->withInput()
    //                 ->with('warning_echange', [
    //                     'message' => "L'ordre « {$newOrdre} » est déjà utilisé par « {$conflict->titre} ».",
    //                     'conflict_id' => $conflict->id,
    //                     'conflict_titre' => $conflict->titre,
    //                     'new_ordre' => $newOrdre,
    //                     'current_ordre' => $photo->ordre,
    //                 ]);
    //         }

    //         /*
    //          * L'utilisateur a confirmé :
    //          * on échange les ordres des deux photos.
    //          */
    //         if ($conflict) {

    //             $ancienOrdre = $photo->ordre;

    //             // Ordre temporaire pour éviter le doublon
    //             $tmpOrdre = (Photo::max('ordre') ?? 0) + 5000;

    //             // 1. Libérer temporairement l'ordre du conflit
    //             $conflict->update([
    //                 'ordre' => $tmpOrdre
    //             ]);

    //             // 2. Donner le nouvel ordre à la photo actuelle
    //             $photo->update([
    //                 'ordre' => $newOrdre
    //             ]);

    //             // 3. Donner l'ancien ordre à la photo en conflit
    //             $conflict->update([
    //                 'ordre' => $ancienOrdre
    //             ]);

    //         } else {

    //             // Aucun conflit : on applique simplement le nouvel ordre
    //             $validated['ordre'] = $newOrdre;
    //         }
    //     }

    //     /*
    //      * Mise à jour des informations de la photo.
    //      */
    //     if ($request->hasFile('image')) {

    //         // Supprimer l'ancienne image
    //         if (
    //             $photo->image_url &&
    //             Storage::disk('public')->exists($photo->image_url)
    //         ) {
    //             Storage::disk('public')->delete($photo->image_url);
    //         }

    //         // Enregistrer la nouvelle image
    //         $imagePath = $request->file('image')->store('photos', 'public');

    //         $validated['image_url'] = $imagePath;
    //     }

    //     $validated['est_visible'] = $request->boolean(
    //         'est_visible',
    //         false
    //     );

    //     /*
    //      * Important :
    //      * si l'ordre a été échangé, il ne faut pas réécrire
    //      * l'ancien ordre avec $validated.
    //      */
    //     if (
    //         $newOrdre === $photo->ordre ||
    //         !isset($conflict)
    //     ) {
    //         if ($newOrdre !== $photo->ordre) {
    //             $validated['ordre'] = $newOrdre;
    //         }
    //     }

    //     /*
    //      * Si un conflit a été traité par échange,
    //      * l'ordre de $photo a déjà été modifié.
    //      */
    //     if (
    //         $newOrdre !== $photo->ordre &&
    //         isset($conflict) &&
    //         $conflict
    //     ) {
    //         unset($validated['ordre']);
    //     }

    //     $photo->update($validated);

    //     return redirect()
    //         ->route('admin.photos.index')
    //         ->with('success', 'La photo a été modifiée avec succès.');
    // }

    /**
     * Supprimer une photo.
     */
    public function destroy(Photo $photo): RedirectResponse
    {
        // Supprimer le fichier image
        $this->supprimerImagePublique($photo->image_url);

        $photo->delete();

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'La photo a été supprimée avec succès.');
    }

    /**
     * Validation commune.
     */
    private function validatePhoto(
        Request $request,
        ?int $ignoreId = null
    ): array {

        return $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                $ignoreId === null ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120',
            ],

            'ordre' => [
                'nullable',
                'integer',
                'min:0',
                'max:32767',
            ],

            'est_visible' => [
                'nullable',
                'boolean',
            ],
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'image.required' => "L'image est obligatoire.",
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => "L'image doit être au format JPEG, PNG, JPG, GIF ou WEBP.",
            'image.max' => "L'image ne doit pas dépasser 5 Mo.",
            'ordre.integer' => "L'ordre doit être un nombre entier.",
            'ordre.min' => "L'ordre ne peut pas être négatif.",
            'ordre.max' => "L'ordre doit être inférieur ou égal à 32767.",
        ]);
    }

    /**
     * Enregistre une image uploadée dans public/photos.
     * Retourne le chemin relatif (ex. : photos/abcd….jpg).
     */
    private function sauvegarderImagePublique(
        \Illuminate\Http\UploadedFile $fichier
    ): string {
        $chemin = $fichier->hashName('photos');

        $fichier->move(public_path('photos'), basename($chemin));

        return $chemin;
    }

    /**
     * Supprime une image du dossier public/photos si elle existe.
     */
    private function supprimerImagePublique(?string $imageUrl): void
    {
        if ($imageUrl && is_file(public_path($imageUrl))) {
            File::delete(public_path($imageUrl));
        }
    }
}

