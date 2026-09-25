<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Filiere;
use App\Models\CategorieFormation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FormationController extends Controller
{
    /**
     * Liste des formations
     */
    public function index(Request $request): View
{
    $query = Formation::with([
        'filiere',
        'categorie',
        'createur'
    ]);

    // Recherche
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
                ->orWhere('resume', 'LIKE', "%{$search}%")
                ->orWhere('mots_cles', 'LIKE', "%{$search}%");
        });
    }

    // Filtre type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filtre filière
    if ($request->filled('filiere_id')) {
        $query->where('filiere_id', $request->filiere_id);
    }

    // Filtre catégorie
    if ($request->filled('categorie_id')) {
        $query->where('categorie_id', $request->categorie_id);
    }

    // Filtre statut
    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    $query->latest();

    // Pagination : 10, 25, 50, 100 ou "tous"
    $perPage = $request->input('per_page', 10);

    if ($perPage === 'tous') {
        $total = (clone $query)->count();
        $formations = $query->paginate($total > 0 ? $total : 1);
    } else {
        $perPage = in_array((int) $perPage, [10, 25, 50, 100], true)
            ? (int) $perPage
            : 10;

        $formations = $query->paginate($perPage);
    }

    $formations->withQueryString();

    $filieres = Filiere::orderBy('nom')->get();
    $categories = CategorieFormation::orderBy('nom')->get();

    return view(
        'admin.formations.index',
        compact(
            'formations',
            'filieres',
            'categories'
        )
    );
}


    /**
     * Formulaire de création
     */
    public function create(): View
    {
        $filieres = Filiere::orderBy('nom')->get();
        $categories = CategorieFormation::orderBy('nom')->get();

        return view(
            'admin.formations.create',
            compact(
                'filieres',
                'categories'
            )
        );
    }


    /**
     * Enregistrer une nouvelle formation
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => [
                'nullable',
                'in:academique,continue_programmee,continue_a_la_carte'
            ],

            'filiere_id' => [
                'nullable',
                'exists:filieres,id'
            ],

            'categorie_id' => [
                'required',
                'exists:categories_formation,id'
            ],

            'titre' => [
                'required',
                'string',
                'max:255'
            ],

            'resume' => [
                'nullable',
                'string'
            ],

            'objectifs' => [
                'nullable',
                'string'
            ],

            'contenu_programme' => [
                'nullable',
                'string'
            ],

            'duree' => [
                'nullable',
                'string',
                'max:255'
            ],

            'public_cible' => [
                'nullable',
                'string'
            ],

            'cout_indicatif' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ],

            'mots_cles' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'statut' => [
                'required',
                'in:ouverte,cloturee,brouillon'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Enregistrement de l'image
        |--------------------------------------------------------------------------
        |
        | Les images seront enregistrées dans :
        |
        | public/formations/
        |
        | Exemple :
        | public/formations/sig-master.jpg
        |
        */

        if ($request->hasFile('image')) {

            // Créer le dossier s'il n'existe pas
            $destinationPath = public_path('formations');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Récupérer le fichier
            $image = $request->file('image');

            // Générer un nom unique
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Déplacer l'image vers public/formations
            $image->move(
                $destinationPath,
                $imageName
            );

            // Enregistrer le chemin dans la base
            $validated['image_url'] = 'formations/' . $imageName;
        }


        // Ne pas enregistrer le champ image dans la base
        unset($validated['image']);


        // Utilisateur connecté
        $validated['created_by'] = Auth::id();


        // Création de la formation
        $formation = Formation::create($validated);


        return redirect()
            ->route('admin.formations.index')
            ->with(
                'success',
                "La formation « {$formation->titre} » a été créée avec succès."
            );
    }


    /**
     * Afficher une formation
     */
    public function show(Formation $formation): View
    {
        $formation->load([
            'filiere',
            'categorie',
            'createur',
            'sessions'
        ]);

        return view(
            'admin.formations.show',
            compact('formation')
        );
    }


    /**
     * Formulaire de modification
     */
    public function edit(Formation $formation): View
    {
        $filieres = Filiere::orderBy('nom')->get();
        $categories = CategorieFormation::orderBy('nom')->get();

        return view(
            'admin.formations.edit',
            compact(
                'formation',
                'filieres',
                'categories'
            )
        );
    }


    /**
     * Modifier une formation
     */
    public function update(
        Request $request,
        Formation $formation
    ): RedirectResponse {

        $validated = $request->validate([
            'type' => [
                'nullable',
                'in:academique,continue_programmee,continue_a_la_carte'
            ],

            'filiere_id' => [
                'nullable',
                'exists:filieres,id'
            ],

            'categorie_id' => [
                'required',
                'exists:categories_formation,id'
            ],

            'titre' => [
                'required',
                'string',
                'max:255'
            ],

            'resume' => [
                'nullable',
                'string'
            ],

            'objectifs' => [
                'nullable',
                'string'
            ],

            'contenu_programme' => [
                'nullable',
                'string'
            ],

            'duree' => [
                'nullable',
                'string',
                'max:255'
            ],

            'public_cible' => [
                'nullable',
                'string'
            ],

            'cout_indicatif' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120'
            ],

            'mots_cles' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'statut' => [
                'required',
                'in:ouverte,cloturee,brouillon'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Nouvelle image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $destinationPath = public_path('formations');

            // Créer le dossier s'il n'existe pas
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }


            /*
            |--------------------------------------------------------------------------
            | Supprimer l'ancienne image
            |--------------------------------------------------------------------------
            */

            if (!empty($formation->image_url)) {

                $oldImage = public_path($formation->image_url);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Enregistrer la nouvelle image
            |--------------------------------------------------------------------------
            */

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(
                $destinationPath,
                $imageName
            );


            /*
            |--------------------------------------------------------------------------
            | Nouveau chemin en base
            |--------------------------------------------------------------------------
            */

            $validated['image_url'] = 'formations/' . $imageName;
        }


        // Ne pas enregistrer le champ image
        unset($validated['image']);


        // Mise à jour
        $formation->update($validated);


        return redirect()
            ->route('admin.formations.index')
            ->with(
                'success',
                "La formation « {$formation->titre} » a été mise à jour avec succès."
            );
    }


    /**
     * Supprimer une formation
     */
    public function destroy(Formation $formation): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Vérifier les sessions
        |--------------------------------------------------------------------------
        */

        if ($formation->sessions()->exists()) {

            return redirect()
                ->route('admin.formations.index')
                ->with(
                    'error',
                    'Cette formation ne peut pas être supprimée car elle possède déjà une ou plusieurs sessions.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer l'image
        |--------------------------------------------------------------------------
        */

        if (!empty($formation->image_url)) {

            $imagePath = public_path($formation->image_url);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Supprimer la formation
        |--------------------------------------------------------------------------
        */

        $titre = $formation->titre;

        $formation->delete();


        return redirect()
            ->route('admin.formations.index')
            ->with(
                'success',
                "La formation « {$titre} » a été supprimée avec succès."
            );
    }


    /**
     * Changer le statut
     */
    public function changerStatut(
        Request $request,
        Formation $formation
    ): RedirectResponse {

        $validated = $request->validate([
            'statut' => [
                'required',
                'in:ouverte,cloturee,brouillon'
            ],
        ]);

        $formation->update([
            'statut' => $validated['statut']
        ]);

        return back()->with(
            'success',
            'Le statut de la formation a été modifié avec succès.'
        );
    }
}
