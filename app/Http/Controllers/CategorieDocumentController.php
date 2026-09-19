<?php

namespace App\Http\Controllers;

use App\Models\CategorieDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieDocumentController extends Controller
{
    /**
     * Liste des catégories
     */
    public function index(Request $request): View
    {
        $query = CategorieDocument::query();

        // Recherche
        if ($request->filled('recherche')) {
            $query->where(
                'nom',
                'ilike',
                '%' . $request->recherche . '%'
            );
        }

        $categories = $query
            ->orderBy('nom')
            ->paginate(10);

        return view(
            'admin.categories-documents.index',
            compact('categories')
        );
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        return view(
            'admin.categories-documents.create'
        );
    }

    /**
     * Enregistrement
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:150',
            ],
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.string' => 'Le nom de la catégorie doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne doit pas dépasser 150 caractères.',
        ]);

        CategorieDocument::create($validated);

        return redirect()
            ->route('admin.categories-documents.index')
            ->with(
                'success',
                'Catégorie de document créée avec succès.'
            );
    }

    /**
     * Affichage d'une catégorie
     */
    public function show(CategorieDocument $categorie): View
    {
        return view(
            'admin.categories-documents.show',
            compact('categorie')
        );
    }

    /**
     * Formulaire de modification
     */
    public function edit(CategorieDocument $categorie): View
    {
        return view(
            'admin.categories-documents.edit',
            compact('categorie')
        );
    }

    /**
     * Mise à jour
     */
    public function update(
        Request $request,
        CategorieDocument $categorie
    ): RedirectResponse {

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:150',
            ],
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.string' => 'Le nom de la catégorie doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne doit pas dépasser 150 caractères.',
        ]);

        $categorie->update($validated);

        return redirect()
            ->route('admin.categories-documents.index')
            ->with(
                'success',
                'Catégorie de document modifiée avec succès.'
            );
    }

    /**
     * Suppression
     */
    public function destroy(
        CategorieDocument $categorie
    ): RedirectResponse {

        $categorie->delete();

        return redirect()
            ->route('admin.categories-documents.index')
            ->with(
                'success',
                'Catégorie de document supprimée avec succès.'
            );
    }
}
