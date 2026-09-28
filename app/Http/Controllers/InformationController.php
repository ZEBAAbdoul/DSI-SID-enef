<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InformationController extends Controller
{
    public function index(): View
    {
        $informations = Information::orderByDesc('created_at')->paginate(10);

        return view('admin.informations.index', compact('informations'));
    }

    public function create(): View
    {
        return view('admin.informations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('fichier')) {
            $data['fichier_path'] = $request->file('fichier')->store('informations');
            $data['fichier_nom']  = $request->file('fichier')->getClientOriginalName();
        }

        $data['est_publie'] = $request->boolean('est_publie');
        $data['publie_le']  = $data['est_publie'] ? now() : null;
        $data['created_by'] = auth()->id();

        Information::create($data);

        return redirect()->route('admin.informations.index')
            ->with('status', 'Information enregistrée avec succès.');
    }

    public function edit(Information $information): View
    {
        return view('admin.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information): RedirectResponse
    {
        $data = $this->validated($request);

        // Suppression demandée, ou remplacement par un nouveau fichier
        if ($request->boolean('supprimer_fichier') || $request->hasFile('fichier')) {
            if ($information->fichier_path) {
                Storage::delete($information->fichier_path);
            }
            $data['fichier_path'] = null;
            $data['fichier_nom']  = null;
        }

        if ($request->hasFile('fichier')) {
            $data['fichier_path'] = $request->file('fichier')->store('informations');
            $data['fichier_nom']  = $request->file('fichier')->getClientOriginalName();
        }

        $data['est_publie'] = $request->boolean('est_publie');
        // publie_le : date de la première publication
        $data['publie_le'] = $data['est_publie']
            ? ($information->publie_le ?? now())
            : null;

        $information->update($data);

        return redirect()->route('admin.informations.index')
            ->with('status', 'Information mise à jour avec succès.');
    }

    public function destroy(Information $information): RedirectResponse
    {
        if ($information->fichier_path) {
            Storage::delete($information->fichier_path);
        }

        $information->delete();

        return redirect()->route('admin.informations.index')
            ->with('status', 'Information supprimée.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'titre'   => ['required', 'string', 'max:200'],
            'contenu' => ['required', 'string'],
            'cible'   => ['required', 'in:' . implode(',', array_keys(Information::CIBLES))],
            'fichier' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],   // 5 Mo
        ]);
    }
}