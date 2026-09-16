<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Filiere;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatiereController extends Controller
{
    public function index(Request $request): View
    {
        $matieres = Matiere::with('filiere')
            ->when(
                $request->filled('recherche'),
                fn ($q) => $q->where(function ($query) use ($request) {
                    $query->where('nom', 'LIKE', "%{$request->recherche}%")
                        ->orWhere('code', 'LIKE', "%{$request->recherche}%");
                })
            )
            ->when(
                $request->filled('filiere_id'),
                fn ($q) => $q->where('filiere_id', $request->filiere_id)
            )
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        $filieres = Filiere::orderBy('nom')->get();

        return view('admin.matieres.index', compact('matieres', 'filieres'));
    }

    public function create(): View
    {
        $filieres = Filiere::orderBy('nom')->get();

        return view('admin.matieres.create', compact('filieres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMatiere($request);

        Matiere::create($validated);

        return redirect()
            ->route('admin.matieres.index')
            ->with('status', 'Matière créée avec succès.');
    }

    public function edit(Matiere $matiere): View
    {
        $matiere->load('filiere');

        $filieres = Filiere::orderBy('nom')->get();

        return view('admin.matieres.edit', compact('matiere', 'filieres'));
    }

    public function update(Request $request, Matiere $matiere): RedirectResponse
    {
        $validated = $this->validateMatiere($request, $matiere->id);

        $matiere->update($validated);

        return redirect()
            ->route('admin.matieres.index')
            ->with('status', 'Matière mise à jour avec succès.');
    }

    public function destroy(Matiere $matiere): RedirectResponse
    {
        if ($matiere->notes()->exists()) {
            return redirect()
                ->route('admin.matieres.index')
                ->with('erreur_matiere', 'Impossible de supprimer cette matière : des notes y sont rattachées.');
        }

        $matiere->delete();

        return redirect()
            ->route('admin.matieres.index')
            ->with('status', 'Matière supprimée.');
    }

    private function validateMatiere(Request $request, ?int $ignoreId = null): array
    {
        $uniqueCode = 'unique:matieres,code';

        if ($ignoreId !== null) {
            $uniqueCode .= ',' . $ignoreId;
        }

        return $request->validate([
            'filiere_id'    => ['nullable', 'string', 'exists:filieres,id'],
            'nom'           => ['required', 'string', 'max:150'],
            'code'          => ['nullable', 'string', 'max:20', $uniqueCode],
            'coefficient'   => ['required', 'numeric', 'min:0', 'max:99'],
            'volume_horaire'=> ['nullable', 'integer', 'min:0', 'max:10000'],
        ], [
            'nom.required'      => 'Le nom de la matière est obligatoire.',
            'code.unique'       => 'Ce code est déjà utilisé.',
            'coefficient.max'   => 'Le coefficient doit être inférieur à 100.',
            'volume_horaire.max'=> 'Le volume horaire est trop élevé.',
        ]);
    }
}