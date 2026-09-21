<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class IdeeController extends Controller
{
    /** Mes idées : uniquement celles de l'utilisateur connecté. */
    public function index(): View
    {
        $this->authorize('soumettre', Idee::class);

        $idees = Idee::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('admin.idees.index', compact('idees'));
    }

    public function create(): View
    {
        $this->authorize('soumettre', Idee::class);

        return view('admin.idees.create', ['idee' => new Idee()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('soumettre', Idee::class);

        Idee::create($this->validated($request) + [
            'user_id' => auth()->id(),
            'statut' => 'soumise',
        ]);

        return redirect()
            ->route('admin.idees.index')
            ->with('success', "Merci, votre idée a bien été transmise à la direction.");
    }

    public function edit(Idee $idee): View
    {
        $this->authorize('update', $idee);

        return view('admin.idees.edit', compact('idee'));
    }

    public function update(Request $request, Idee $idee): RedirectResponse
    {
        $this->authorize('update', $idee);

        $idee->update($this->validated($request));

        return redirect()
            ->route('admin.idees.index')
            ->with('success', 'Idée mise à jour.');
    }

    public function destroy(Idee $idee): RedirectResponse
    {
        $this->authorize('delete', $idee);

        $idee->delete();

        return redirect()
            ->route('admin.idees.index')
            ->with('success', 'Idée supprimée.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'titre' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'categorie' => ['nullable', Rule::in(array_keys(Idee::CATEGORIES))],
        ], [
            'titre.required' => "Donnez un titre à votre idée.",
            'description.required' => "Décrivez votre idée.",
            'description.min' => "Décrivez votre idée un peu plus (20 caractères minimum).",
            'description.max' => "La description ne doit pas dépasser 2000 caractères.",
        ]);
    }
}