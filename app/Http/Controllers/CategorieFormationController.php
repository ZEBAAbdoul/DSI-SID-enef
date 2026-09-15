<?php

namespace App\Http\Controllers;

use App\Models\CategorieFormation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieFormationController extends Controller
{
    public function index(Request $request): View
    {
        $categories = CategorieFormation::withCount('formations')
            ->when(
                $request->filled('recherche'),
                fn ($q) => $q->where('nom', 'LIKE', "%{$request->recherche}%")
            )
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories-formation.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories-formation.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategorie($request);

        CategorieFormation::create($validated);

        return redirect()
            ->route('admin.categories-formation.index')
            ->with('status', 'Catégorie créée avec succès.');
    }

    public function edit(CategorieFormation $categoriesFormation): View
    {
        return view('admin.categories-formation.edit', [
            'categorie' => $categoriesFormation,
        ]);
    }

    public function update(Request $request, CategorieFormation $categoriesFormation): RedirectResponse
    {
        $validated = $this->validateCategorie($request, $categoriesFormation->id);

        $categoriesFormation->update($validated);

        return redirect()
            ->route('admin.categories-formation.index')
            ->with('status', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(CategorieFormation $categoriesFormation): RedirectResponse
    {
        $categoriesFormation->delete();

        return redirect()
            ->route('admin.categories-formation.index')
            ->with('status', 'Catégorie supprimée.');
    }

    private function validateCategorie(Request $request, ?string $ignoreId = null): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:150'],
        ]);
    }
}
