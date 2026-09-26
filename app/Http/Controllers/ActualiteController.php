<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActualiteController extends Controller
{
    /**
     * ============================================================
     * ACTUALITÉS PUBLIQUES
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = Actualite::publiees()
            ->orderBy('ordre_menu', 'asc')
            ->orderBy('created_at', 'desc');

        // Recherche
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('titre', 'ILIKE', '%' . $search . '%')
                    ->orWhere('chapo', 'ILIKE', '%' . $search . '%')
                    ->orWhere('contenu', 'ILIKE', '%' . $search . '%');
            });
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $actualites = $query
            ->paginate(9)
            ->withQueryString();

        $types = [
            'institutionnelle' => 'Institutionnelle',
            'formation'        => 'Formation',
            'evenement'        => 'Événement',
            'partenariat'      => 'Partenariat',
            'communique'       => 'Communiqué',
        ];

        return view('actualites.index', compact(
            'actualites',
            'types'
        ));
    }


    /**
     * ============================================================
     * AFFICHER UNE ACTUALITÉ
     * ============================================================
     */
    public function show($slug)
    {
        $actualite = Actualite::publiees()
            ->where('slug', $slug)
            ->firstOrFail();

        // Actualités récentes pour la colonne latérale
        $recentes = Actualite::publiees()
            ->where('id', '!=', $actualite->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('actualites.show', compact(
            'actualite',
            'recentes'
        ));
    }


    /**
     * ============================================================
     * ADMINISTRATION : LISTE
     * ============================================================
     */
    public function adminIndex(Request $request)
    {
        $query = Actualite::query()
            ->orderBy('ordre_menu', 'asc')
            ->orderBy('created_at', 'desc');

        // Recherche
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('titre', 'ILIKE', '%' . $search . '%')
                    ->orWhere('chapo', 'ILIKE', '%' . $search . '%')
                    ->orWhere('contenu', 'ILIKE', '%' . $search . '%');
            });
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par statut
        if ($request->filled('statut')) {

            if ($request->statut === 'publiee') {
                $query->where('is_publiee', true);
            }

            if ($request->statut === 'brouillon') {
                $query->where('is_publiee', false);
            }
        }

        $actualites = $query
            ->paginate(10)
            ->withQueryString();

        $types = [
            'institutionnelle' => 'Institutionnelle',
            'formation'        => 'Formation',
            'evenement'        => 'Événement',
            'partenariat'      => 'Partenariat',
            'communique'       => 'Communiqué',
        ];

        return view('admin.actualites.index', compact(
            'actualites',
            'types'
        ));
    }


    /**
     * ============================================================
     * FORMULAIRE DE CRÉATION
     * ============================================================
     */
    public function create()
    {
        $types = [
            'institutionnelle' => 'Institutionnelle',
            'formation'        => 'Formation',
            'evenement'        => 'Événement',
            'partenariat'      => 'Partenariat',
            'communique'       => 'Communiqué',
        ];

        return view('admin.actualites.create', compact('types'));
    }


    /**
     * ============================================================
     * ENREGISTRER UNE ACTUALITÉ
     * ============================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
            ],

            'chapo' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contenu' => [
                'required',
                'string',
            ],

            'type' => [
                'required',
                'in:institutionnelle,formation,evenement,partenariat,communique',
            ],

            'ordre_menu' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'lien_facebook' => [
                'nullable',
                'string',
            ],

            'is_publiee' => [
                'nullable',
                'boolean',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',

            'contenu.required' => 'Le contenu est obligatoire.',

            'type.required' => 'Veuillez sélectionner un type.',
            'type.in' => 'Le type sélectionné est invalide.',

            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L’image doit être au format JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'L’image ne doit pas dépasser 5 Mo.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Création de l'actualité
        |--------------------------------------------------------------------------
        */

        $actualite = new Actualite();

        $actualite->titre = $validated['titre'];
        $actualite->chapo = $validated['chapo'] ?? null;
        $actualite->contenu = $validated['contenu'];
        $actualite->lien_facebook = $validated['lien_facebook'];
        $actualite->type = $validated['type'];
        $actualite->ordre_menu = $validated['ordre_menu'] ?? 0;

        $actualite->is_publiee = $request->boolean('is_publiee');

        $actualite->meta_description =
            $validated['meta_description'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Utilisateur connecté
        |--------------------------------------------------------------------------
        */

        if (Auth::check()) {
            $actualite->created_by = Auth::id();
            $actualite->updated_by = Auth::id();
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |
        | Les images sont enregistrées directement dans :
        |
        | public/actualites/
        |
        | Exemple BDD :
        |
        | actualites/reforme-formation.jpg
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $dossier = public_path('actualites');

            // Créer le dossier s'il n'existe pas
            if (!is_dir($dossier)) {
                mkdir($dossier, 0755, true);
            }

            /*
            |--------------------------------------------------------------------------
            | Nom unique
            |--------------------------------------------------------------------------
            */

            $nomImage = Str::slug(
                pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            );

            $extension = $image->getClientOriginalExtension();

            $nomImage .= '-' . time() . '.' . $extension;

            /*
            |--------------------------------------------------------------------------
            | Déplacement dans public/actualites
            |--------------------------------------------------------------------------
            */

            $image->move(
                $dossier,
                $nomImage
            );

            /*
            |--------------------------------------------------------------------------
            | Chemin enregistré en BDD
            |--------------------------------------------------------------------------
            */

            $actualite->image_couverture_url =
                'actualites/' . $nomImage;
        }


        /*
        |--------------------------------------------------------------------------
        | Enregistrement
        |--------------------------------------------------------------------------
        */

        $actualite->save();


        return redirect()
            ->route('admin.actualites.index')
            ->with(
                'success',
                'L’actualité a été créée avec succès.'
            );
    }


    /**
     * ============================================================
     * FORMULAIRE DE MODIFICATION
     * ============================================================
     */
    public function edit(Actualite $actualite)
    {
        $types = [
            'institutionnelle' => 'Institutionnelle',
            'formation'        => 'Formation',
            'evenement'        => 'Événement',
            'partenariat'      => 'Partenariat',
            'communique'       => 'Communiqué',
        ];

        return view(
            'admin.actualites.edit',
            compact(
                'actualite',
                'types'
            )
        );
    }


    /**
     * ============================================================
     * MODIFIER UNE ACTUALITÉ
     * ============================================================
     */
    public function update(
        Request $request,
        Actualite $actualite
    ) {
        $validated = $request->validate([
            'titre' => [
                'required',
                'string',
                'max:255',
            ],

            'chapo' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contenu' => [
                'required',
                'string',
            ],

            'lien_facebook' => [
                'nullable',
                'string',
            ],

            'type' => [
                'required',
                'in:institutionnelle,formation,evenement,partenariat,communique',
            ],

            'ordre_menu' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_publiee' => [
                'nullable',
                'boolean',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le contenu est obligatoire.',

            'type.required' => 'Veuillez sélectionner un type.',
            'type.in' => 'Le type sélectionné est invalide.',

            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L’image doit être au format JPG, JPEG, PNG ou WEBP.',
            'image.max' => 'L’image ne doit pas dépasser 5 Mo.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Mise à jour des informations
        |--------------------------------------------------------------------------
        */

        $actualite->titre = $validated['titre'];
        $actualite->chapo = $validated['chapo'] ?? null;
        $actualite->contenu = $validated['contenu'];
        $actualite->lien_facebook = $validated['lien_facebook'];

        $actualite->type = $validated['type'];
        $actualite->ordre_menu = $validated['ordre_menu'] ?? 0;

        $actualite->is_publiee =
            $request->boolean('is_publiee');

        $actualite->meta_description =
            $validated['meta_description'] ?? null;


        if (Auth::check()) {
            $actualite->updated_by = Auth::id();
        }


        /*
        |--------------------------------------------------------------------------
        | Remplacement de l'image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $dossier = public_path('actualites');

            /*
            |--------------------------------------------------------------------------
            | Supprimer l'ancienne image
            |--------------------------------------------------------------------------
            */

            if (
                !empty($actualite->image_couverture_url)
                &&
                file_exists(
                    public_path(
                        $actualite->image_couverture_url
                    )
                )
            ) {
                unlink(
                    public_path(
                        $actualite->image_couverture_url
                    )
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Créer le dossier si nécessaire
            |--------------------------------------------------------------------------
            */

            if (!is_dir($dossier)) {
                mkdir($dossier, 0755, true);
            }


            /*
            |--------------------------------------------------------------------------
            | Générer le nouveau nom
            |--------------------------------------------------------------------------
            */

            $nomImage = Str::slug(
                pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            );

            $extension = $image->getClientOriginalExtension();

            $nomImage .= '-' . time() . '.' . $extension;


            /*
            |--------------------------------------------------------------------------
            | Déplacer la nouvelle image
            |--------------------------------------------------------------------------
            */

            $image->move(
                $dossier,
                $nomImage
            );


            /*
            |--------------------------------------------------------------------------
            | Enregistrer le chemin
            |--------------------------------------------------------------------------
            */

            $actualite->image_couverture_url =
                'actualites/' . $nomImage;
        }


        $actualite->save();


        return redirect()
            ->route('admin.actualites.index')
            ->with(
                'success',
                'L’actualité a été modifiée avec succès.'
            );
    }


    /**
     * ============================================================
     * SUPPRIMER UNE ACTUALITÉ
     * ============================================================
     */
    public function destroy(Actualite $actualite)
    {
        /*
        |--------------------------------------------------------------------------
        | Supprimer l'image physique
        |--------------------------------------------------------------------------
        */

        if (
            !empty($actualite->image_couverture_url)
            &&
            file_exists(
                public_path(
                    $actualite->image_couverture_url
                )
            )
        ) {
            unlink(
                public_path(
                    $actualite->image_couverture_url
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer l'actualité
        |--------------------------------------------------------------------------
        */

        $actualite->delete();


        return redirect()
            ->route('admin.actualites.index')
            ->with(
                'success',
                'L’actualité a été supprimée avec succès.'
            );
    }


    /**
     * ============================================================
     * PUBLIER UNE ACTUALITÉ
     * ============================================================
     */
    public function publier(Actualite $actualite)
    {
        $actualite->is_publiee = true;

        if (Auth::check()) {
            $actualite->updated_by = Auth::id();
        }

        $actualite->save();


        return redirect()
            ->back()
            ->with(
                'success',
                'L’actualité a été publiée avec succès.'
            );
    }


    /**
     * ============================================================
     * DÉPUBLIER UNE ACTUALITÉ
     * ============================================================
     */
    public function depublier(Actualite $actualite)
    {
        $actualite->is_publiee = false;

        if (Auth::check()) {
            $actualite->updated_by = Auth::id();
        }

        $actualite->save();


        return redirect()
            ->back()
            ->with(
                'success',
                'L’actualité a été dépubliée avec succès.'
            );
    }
}
