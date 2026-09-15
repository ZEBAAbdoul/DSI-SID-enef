<?php

namespace App\Http\Controllers;

use App\Models\TypePiece;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypePieceController extends Controller
{
    public function index(Request $request): View
    {
        $typesPieces = TypePiece::withCount('pieces')
            ->when(
                $request->filled('recherche'),
                fn ($q) => $q->where(function ($q) use ($request) {
                    $q->where('libelle', 'LIKE', "%{$request->recherche}%")
                        ->orWhere('code', 'LIKE', "%{$request->recherche}%");
                })
            )
            ->orderBy('ordre')
            ->paginate(15)
            ->withQueryString();

        return view('admin.types-pieces.index', compact('typesPieces'));
    }

    public function create(): View
    {
        return view('admin.types-pieces.create', [
            'prochainOrdre' => (TypePiece::max('ordre') ?? 0) + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTypePiece($request);

        $validated['ordre'] = (TypePiece::max('ordre') ?? 0) + 1;

        TypePiece::create($validated);

        return redirect()
            ->route('admin.types-pieces.index')
            ->with('status_type_piece', 'Type de pièce créé avec succès.');
    }

    public function edit(TypePiece $typesPiece): View
    {
        return view('admin.types-pieces.edit', compact('typesPiece'));
    }

    public function update(Request $request, TypePiece $typesPiece): RedirectResponse
    {
        $validated = $this->validateTypePiece($request, $typesPiece->id);

        $newOrdre = (int) $request->input('ordre', $typesPiece->ordre);

        if ($newOrdre < 0 || $newOrdre > 32767) {
            return back()->withErrors(['ordre' => "L'ordre doit être entre 0 et 32767."])->withInput();
        }

        if ($newOrdre !== $typesPiece->ordre) {
            $conflict = TypePiece::where('id', '!=', $typesPiece->id)
                ->where('ordre', $newOrdre)
                ->first();

            if ($conflict && !$request->boolean('confirmer_echange')) {
                return back()->withInput()->with('warning_echange', [
                    'message' => "L'ordre « {$newOrdre} » est déjà utilisé par « {$conflict->libelle} ».",
                    'conflict_id' => $conflict->id,
                    'conflict_libelle' => $conflict->libelle,
                    'new_ordre' => $newOrdre,
                    'current_ordre' => $typesPiece->ordre,
                ]);
            }

            if ($conflict) {
                // Échange atomique : libère temporairement l'ordre du conflit
                $ancienOrdre = $typesPiece->ordre;
                $tmpOrdre = (TypePiece::max('ordre') ?? 0) + 5000;

                $conflict->update(['ordre' => $tmpOrdre]);
                $typesPiece->update(['ordre' => $newOrdre]);
                $conflict->update(['ordre' => $ancienOrdre]);
            } else {
                $validated['ordre'] = $newOrdre;
            }
        }

        $typesPiece->update($validated);

        return redirect()
            ->route('admin.types-pieces.index')
            ->with('status_type_piece', 'Type de pièce mis à jour avec succès.');
    }

    public function destroy(TypePiece $typesPiece): RedirectResponse
    {
        if ($typesPiece->pieces()->exists()) {
            return redirect()
                ->route('admin.types-pieces.index')
                ->with('erreur_type_piece', "Impossible de supprimer ce type : des pièces d'inscription y sont rattachées.");
        }

        $typesPiece->delete();

        return redirect()
            ->route('admin.types-pieces.index')
            ->with('status_type_piece', 'Type de pièce supprimé.');
    }

    private function validateTypePiece(Request $request, ?int $ignoreId = null): array
    {
        $uniqueCode = 'unique:types_pieces,code';
        if ($ignoreId !== null) {
            $uniqueCode .= ',' . $ignoreId;
        }

        return $request->validate([
            'code'        => ['required', 'string', 'max:40', $uniqueCode],
            'libelle'     => ['required', 'string', 'max:100'],
            'obligatoire' => ['sometimes', 'boolean'],
            'actif'       => ['sometimes', 'boolean'],
        ], [
            'code.unique' => 'Ce code est déjà utilisé.',
        ]);
    }
}