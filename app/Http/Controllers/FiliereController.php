<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FiliereController extends Controller
{
    public function index(Request $request): View
    {
        $filieres = Filiere::withCount('formations')
            ->when(
                $request->filled('recherche'),
                fn ($q) => $q->where(function ($query) use ($request) {
                    $query->where('nom', 'LIKE', "%{$request->recherche}%")
                        ->orWhere('code', 'LIKE', "%{$request->recherche}%")
                        ->orWhere('responsable', 'LIKE', "%{$request->recherche}%");
                })
            )
            ->orderBy('nom')
            ->paginate(10)
            ->withQueryString();

        return view('admin.filieres.index', compact('filieres'));
    }

    public function create(): View
    {
        return view('admin.filieres.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFiliere($request);

        Filiere::create($validated);

        return redirect()
            ->route('admin.filieres.index')
            ->with('status', 'Filière créée avec succès.');
    }

    public function edit(Filiere $filiere): View
    {
        return view('admin.filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere): RedirectResponse
    {
        $validated = $this->validateFiliere($request, $filiere->id);

        $filiere->update($validated);

        return redirect()
            ->route('admin.filieres.index')
            ->with('status', 'Filière mise à jour avec succès.');
    }

    public function destroy(Filiere $filiere): RedirectResponse
    {
        if ($filiere->formations()->exists()) {
            return redirect()
                ->route('admin.filieres.index')
                ->with('erreur_filiere', 'Impossible de supprimer cette filière : des formations y sont rattachées.');
        }

        $filiere->delete();

        return redirect()
            ->route('admin.filieres.index')
            ->with('status', 'Filière supprimée.');
    }

    private function validateFiliere(Request $request, ?string $ignoreId = null): array
    {
        $uniqueNom = 'unique:filieres,nom';
        $uniqueCode = 'unique:filieres,code';

        if ($ignoreId !== null) {
            $uniqueNom .= ',' . $ignoreId . ',id';
            $uniqueCode .= ',' . $ignoreId . ',id';
        }

        return $request->validate([
            'nom'           => ['required', 'string', 'max:150', $uniqueNom],
            'code'          => ['nullable', 'string', 'max:20', $uniqueCode],
            'description'   => ['nullable', 'string'],
            'responsable'   => ['nullable', 'string', 'max:100'],
            'email_contact' => ['nullable', 'email', 'max:100'],
            'est_active'    => ['sometimes', 'boolean'],
        ], [
            'nom.required' => 'Le nom de la filière est obligatoire.',
            'nom.unique'   => 'Ce nom de filière est déjà utilisé.',
            'code.unique'  => 'Ce code est déjà utilisé.',
        ]);
    }
}
