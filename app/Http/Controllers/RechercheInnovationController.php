<?php

namespace App\Http\Controllers;

use App\Models\RechercheInnovation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RechercheInnovationController extends Controller
{
    /**
     * Seuil à partir duquel une photo est compressée (2 Mo).
     */
    private const TAILLE_COMPRESSION_MAX = 2 * 1024 * 1024;

    /**
     * Plus grand côté autorisé après compression.
     */
    private const LARGEUR_MAX = 1920;
    /**
     * Afficher la liste des recherches et innovations
     */
    public function index(Request $request)
    {
        $types = [
            'recherche'  => 'Recherche',
            'innovation' => 'Innovation',
        ];

        $recherchesInnovations = RechercheInnovation::with([
            'createur',
            'modificateur'
        ])
        ->recherche($request->search)
        ->deType($request->type)
        ->deStatut($request->statut)
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view(
            'admin.recherches_innovations.index',
            compact('recherchesInnovations', 'types')
        );
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.recherches_innovations.create');
    }

    /**
     * Enregistrer une recherche ou une innovation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'chapo' => 'nullable|string',
            'contenu' => 'nullable|string',
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:8192',
            'url_video' => 'nullable|url|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'type' => 'required|in:recherche,innovation',
            'is_publiee' => 'nullable|boolean',
        ]);

        /*
         * Génération du slug
         */
        $slug = Str::slug($validated['titre']);
        $newSlug = $slug;
        $counter = 1;

        while (RechercheInnovation::where('slug', $newSlug)->exists()) {
            $newSlug = $slug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $newSlug;

        /*
         * Upload des photos (plusieurs fichiers possibles)
         */
        $photos = [];
        foreach ($request->file('photo', []) as $fichier) {
            $photos[] = $this->sauvegarderPhotoPublique($fichier);
        }

        if ($photos) {
            $validated['photo'] = $photos;
        }

        /*
         * Upload du document
         */
        if ($request->hasFile('document')) {
            $validated['document'] = $this->sauvegarderDocumentPublique(
                $request->file('document')
            );
            $validated['document_nom'] = $request->file('document')->getClientOriginalName();
        }

        /*
         * Statut de publication
         */
        $validated['is_publiee'] = $request->boolean('is_publiee');

        /*
         * Utilisateur connecté
         */
        if (Auth::check()) {
            $validated['created_by'] = Auth::id();
        }

        /*
         * Création
         */
        RechercheInnovation::create($validated);

        return redirect()
            ->route('admin.recherches-innovations.index')
            ->with('success', 'La recherche/innovation a été créée avec succès.');
    }

    /**
     * Afficher une recherche ou une innovation
     */
    public function show(string $id)
    {
        $rechercheInnovation = RechercheInnovation::with([
            'createur',
            'modificateur'
        ])->findOrFail($id);

        return view(
            'recherches_innovations.show',
            compact('rechercheInnovation')
        );
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(string $id)
    {
        $rechercheInnovation = RechercheInnovation::findOrFail($id);

        return view(
            'admin.recherches_innovations.edit',
            compact('rechercheInnovation')
        );
    }

    /**
     * Modifier une recherche ou une innovation
     */
    public function update(Request $request, string $id)
    {
        $rechercheInnovation = RechercheInnovation::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'chapo' => 'nullable|string',
            'contenu' => 'nullable|string',
            'photo' => 'nullable|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:8192',
            'url_video' => 'nullable|url|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'type' => 'required|in:recherche,innovation',
            'is_publiee' => 'nullable|boolean',
            'photos_actuelles' => 'nullable|array',
            'photos_actuelles.*' => 'string',
            'supprimer_photos' => 'nullable|array',
            'supprimer_photos.*' => 'string',
        ]);

        /*
         * Régénération du slug si le titre a changé
         */
        if ($rechercheInnovation->titre !== $validated['titre']) {

            $slug = Str::slug($validated['titre']);
            $newSlug = $slug;
            $counter = 1;

            while (
                RechercheInnovation::where('slug', $newSlug)
                    ->where('id', '!=', $rechercheInnovation->id)
                    ->exists()
            ) {
                $newSlug = $slug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $newSlug;
        }

        /*
         * Gestion des photos :
         *  - photos_actuelles[] : photos conservées (valeur cachée du formulaire)
         *  - supprimer_photos[] : photos cochées pour être retirées
         *  - photo[]           : nouveaux fichiers uploadés
         */
        $actuelles = $request->input('photos_actuelles', []);
        $aRetirer = $request->input('supprimer_photos', []);

        $gardees = array_values(array_diff($actuelles, $aRetirer));

        // Suppression sur disque des photos retirées
        foreach (array_diff($actuelles, $gardees) as $supprimee) {
            $this->supprimerFichierPublique($supprimee);
        }

        $nouvelles = [];
        foreach ($request->file('photo', []) as $fichier) {
            $nouvelles[] = $this->sauvegarderPhotoPublique($fichier);
        }

        $photos = array_merge($gardees, $nouvelles);

        if ($photos) {
            $validated['photo'] = $photos;
        } elseif (!empty($actuelles) && $gardees === [] && !$nouvelles) {
            // Toutes les photos existantes ont été retirées
            $validated['photo'] = [];
        }

        /*
         * Nouveau document
         */
        if ($request->hasFile('document')) {

            $this->supprimerFichierPublique($rechercheInnovation->document);

            $validated['document'] = $this->sauvegarderDocumentPublique(
                $request->file('document')
            );
            $validated['document_nom'] = $request->file('document')->getClientOriginalName();
        }

        /*
         * Statut de publication
         */
        $validated['is_publiee'] = $request->boolean('is_publiee');

        /*
         * Utilisateur ayant effectué la modification
         */
        if (Auth::check()) {
            $validated['updated_by'] = Auth::id();
        }

        $rechercheInnovation->update($validated);

        return redirect()
            ->route('admin.recherches-innovations.index')
            ->with('success', 'La recherche/innovation a été modifiée avec succès.');
    }

    /**
     * Supprimer une recherche ou une innovation
     */
    public function destroy(string $id)
    {
        $rechercheInnovation = RechercheInnovation::findOrFail($id);

        /*
         * Supprimer les photos
         */
        foreach ($rechercheInnovation->photo_list as $photo) {
            $this->supprimerFichierPublique($photo);
        }

        /*
         * Supprimer le document
         */
        $this->supprimerFichierPublique($rechercheInnovation->document);

        $rechercheInnovation->delete();

        return redirect()
            ->route('admin.recherches-innovations.index')
            ->with('success', 'La recherche/innovation a été supprimée avec succès.');
    }

    /**
     * Publier une recherche ou une innovation
     */
    public function publier(string $id)
    {
        $rechercheInnovation = RechercheInnovation::findOrFail($id);

        $rechercheInnovation->is_publiee = true;

        if (Auth::check()) {
            $rechercheInnovation->updated_by = Auth::id();
        }

        $rechercheInnovation->save();

        return redirect()
            ->back()
            ->with('success', 'La recherche/innovation a été publiée avec succès.');
    }

    /**
     * Dépublier une recherche ou une innovation
     */
    public function depublier(string $id)
    {
        $rechercheInnovation = RechercheInnovation::findOrFail($id);

        $rechercheInnovation->is_publiee = false;

        if (Auth::check()) {
            $rechercheInnovation->updated_by = Auth::id();
        }

        $rechercheInnovation->save();

        return redirect()
            ->back()
            ->with('success', 'La recherche/innovation a été dépubliée avec succès.');
    }

    /**
     * Enregistre une photo uploadée dans public/recherches_innovations/photos.
     * Les photos de plus de 2 Mo sont automatiquement compressées
     * (redimensionnées à 1920 px maximum) avant l'enregistrement.
     * Retourne le chemin relatif (ex. : recherches_innovations/photos/abcd….jpg).
     */
    private function sauvegarderPhotoPublique(
        \Illuminate\Http\UploadedFile $fichier
    ): string {
        $cheminCompresse = $this->compresserPhotoPublique($fichier);

        if ($cheminCompresse !== null) {
            return $cheminCompresse;
        }

        $chemin = $fichier->hashName('recherches_innovations/photos');

        $fichier->move(
            public_path('recherches_innovations/photos'),
            basename($chemin)
        );

        return $chemin;
    }

    /**
     * Compresse une photo de plus de 2 Mo avec GD et l'écrit dans
     * public/recherches_innovations/photos. Retourne le chemin relatif
     * écrit, ou null si la compression ne peut pas être appliquée
     * (photo déjà légère, GD indisponible, image illisible, etc.).
     */
    private function compresserPhotoPublique(
        \Illuminate\Http\UploadedFile $fichier
    ): ?string {
        if ($fichier->getSize() <= self::TAILLE_COMPRESSION_MAX) {
            return null;
        }

        if (!function_exists('imagecreatefromstring')) {
            return null;
        }

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        $mime = $fichier->getMimeType();

        if (!isset($extensions[$mime])) {
            return null;
        }

        $contenu = $fichier->get();

        if ($contenu === null || $contenu === '') {
            return null;
        }

        $image = @imagecreatefromstring($contenu);

        if ($image === false) {
            return null;
        }

        // Redimensionnement si le plus grand côté dépasse 1920 px
        $largeur = imagesx($image);
        $hauteur = imagesy($image);

        if (max($largeur, $hauteur) > self::LARGEUR_MAX) {
            $ratio = self::LARGEUR_MAX / max($largeur, $hauteur);

            $nouvelleLargeur = (int) round($largeur * $ratio);
            $nouvelleHauteur = (int) round($hauteur * $ratio);

            $reduite = imagecreatetruecolor(
                $nouvelleLargeur,
                $nouvelleHauteur
            );

            if ($reduite === false) {
                imagedestroy($image);
                return null;
            }

            if ($mime === 'image/png') {
                imagealphablending($reduite, false);
                imagesavealpha($reduite, true);
            }

            imagecopyresampled(
                $reduite,
                $image,
                0,
                0,
                0,
                0,
                $nouvelleLargeur,
                $nouvelleHauteur,
                $largeur,
                $hauteur
            );

            imagedestroy($image);
            $image = $reduite;
        }

        $dossier = public_path('recherches_innovations/photos');

        if (!is_dir($dossier)) {
            mkdir($dossier, 0775, true);
        }

        $destination = $dossier . DIRECTORY_SEPARATOR
            . Str::random(40) . '.' . $extensions[$mime];

        if ($mime === 'image/jpeg') {
            $ecrit = imagejpeg($image, $destination, 82);
        } elseif ($mime === 'image/webp') {
            $ecrit = imagewebp($image, $destination, 82);
        } else { // image/png (conserve la transparence)
            imagealphablending($image, false);
            imagesavealpha($image, true);
            $ecrit = imagepng($image, $destination, 6);
        }

        imagedestroy($image);

        if (
            $ecrit
            && is_file($destination)
            && filesize($destination) < $fichier->getSize()
        ) {
            return 'recherches_innovations/photos/'
                . basename($destination);
        }

        // La compression n'a pas donné de gain : on garde l'original
        if (is_file($destination)) {
            @unlink($destination);
        }

        return null;
    }

    /**
     * Enregistre un document uploadé dans public/recherches_innovations/documents.
     * Retourne le chemin relatif (ex. : recherches_innovations/documents/abcd….pdf).
     */
    private function sauvegarderDocumentPublique(
        \Illuminate\Http\UploadedFile $fichier
    ): string {
        $chemin = $fichier->hashName('recherches_innovations/documents');

        $fichier->move(
            public_path('recherches_innovations/documents'),
            basename($chemin)
        );

        return $chemin;
    }

    /**
     * Supprime un fichier (photo ou document) de public/ si présent.
     */
    private function supprimerFichierPublique(?string $chemin): void
    {
        if ($chemin && is_file(public_path($chemin))) {
            File::delete(public_path($chemin));
        }
    }
}
