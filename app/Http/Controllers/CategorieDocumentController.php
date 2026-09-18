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
    public function index(): View
    {
        $categories = CategorieDocument::with('enfants')
            ->whereNull('parent_id')
            ->orderBy('nom')
            ->get();

        return view('admin.categories-documents.index', compact('categories'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        $categories = CategorieDocument::whereNull('parent_id')
            ->orderBy('nom')
            ->get();

        return view('admin.categories-documents.create', compact('categories'));
    }

    /**
     * Enregistrement
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:150'],
            'parent_id' => [
                'nullable',
                'exists:categories_documents,id',
            ],
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 150 caractères.',
            'parent_id.exists' => 'La catégorie parente sélectionnée est invalide.',
        ]);

        CategorieDocument::create($validated);

        return redirect()
            ->route('admin.categories-documents.index')
            ->with('success', 'Catégorie de document créée avec succès.');
    }

    /**
     * Affichage d'une catégorie
     */
    public function show(CategorieDocument $categorie): View
    {
        $categorie->load([
            'enfants',
            'documents',
        ]);

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
        $categories = CategorieDocument::whereNull('parent_id')
            ->where('id', '!=', $categorie->id)
            ->orderBy('nom')
            ->get();

        return view(
            'admin.categories-documents.edit',
            compact('categorie', 'categories')
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
            'nom' => ['required', 'string', 'max:150'],
            'parent_id' => [
                'nullable',
                'exists:categories_documents,id',
            ],
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 150 caractères.',
            'parent_id.exists' => 'La catégorie parente sélectionnée est invalide.',
        ]);

        $categorie->update($validated);

        return redirect()
            ->route('admin.categories-documents.index')
            ->with('success', 'Catégorie de document modifiée avec succès.');
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
            ->with('success', 'Catégorie de document supprimée avec succès.');
    }
}

