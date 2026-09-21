<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IdeeDirectionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('voirToutes', Idee::class);

        $idees = Idee::with('user.personne')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = '%' . $request->q . '%';
                $query->where(fn ($sub) => $sub
                    ->where('titre', 'ilike', $q)
                    ->orWhere('description', 'ilike', $q));
            })
            ->when($request->filled('statut'), fn ($query) => $query->where('statut', $request->statut))
            ->when($request->filled('categorie'), fn ($query) => $query->where('categorie', $request->categorie))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Compteurs par statut pour les pastilles de filtre
        $compteurs = Idee::selectRaw('statut, count(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        return view('admin.idees-direction.index', compact('idees', 'compteurs'));
    }

    public function show(Idee $idee): View
    {
        $this->authorize('view', $idee);

        $idee->load('user.personne', 'traiteePar.personne');

        return view('admin.idees-direction.show', compact('idee'));
    }

    /** Changer le statut et répondre à l'auteur. */
    public function update(Request $request, Idee $idee): RedirectResponse
    {
        $this->authorize('traiter', Idee::class);

        $data = $request->validate([
            'statut' => ['required', Rule::in(array_keys(Idee::STATUTS))],
            'reponse' => ['nullable', 'string', 'max:1000'],
        ], [
            'statut.required' => 'Choisissez un statut.',
            'reponse.max' => 'La réponse ne doit pas dépasser 1000 caractères.',
        ]);

        $idee->update($data + [
            'traitee_par' => auth()->id(),
            'traitee_le' => now(),
        ]);

        return redirect()
            ->route('admin.idees-direction.show', $idee)
            ->with('success', 'Idée mise à jour. Son auteur verra le nouveau statut.');
    }
}