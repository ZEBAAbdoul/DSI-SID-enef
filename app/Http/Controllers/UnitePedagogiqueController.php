<?php

namespace App\Http\Controllers;

use App\Models\UnitePedagogique;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UnitePedagogiqueController extends Controller
{
    public function index(): View
    {
        $unites = UnitePedagogique::orderBy('ordre')->get();

        return view('admin.unites-pedagogiques.index', compact('unites'));
    }

    public function create(): View
    {
        return view('admin.unites-pedagogiques.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $unite = new UnitePedagogique($this->prepareData($data));

        if ($request->hasFile('photo')) {
            $unite->photo = $request->file('photo')->store('unites-pedagogiques', 'public');
        }

        $unite->save();

        return redirect()
            ->route('admin.unites-pedagogiques.index')
            ->with('success', 'Unité pédagogique créée avec succès.');
    }

    public function show(UnitePedagogique $unite_pedagogique): View
    {
        return view('admin.unites-pedagogiques.show', [
            'unite' => $unite_pedagogique,
        ]);
    }

    public function edit(UnitePedagogique $unite_pedagogique): View
    {
        return view('admin.unites-pedagogiques.edit', [
            'unite' => $unite_pedagogique,
        ]);
    }

    public function update(Request $request, UnitePedagogique $unite_pedagogique): RedirectResponse
    {
        $data = $request->validate($this->rules($unite_pedagogique));

        $unite_pedagogique->fill($this->prepareData($data, $unite_pedagogique));

        if ($request->hasFile('photo')) {
            // Remplace : supprime l'ancien fichier avant d'enregistrer le nouveau
            if ($unite_pedagogique->photo) {
                Storage::disk('public')->delete($unite_pedagogique->photo);
            }
            $unite_pedagogique->photo = $request->file('photo')->store('unites-pedagogiques', 'public');
        } elseif ($request->boolean('supprimer_photo') && $unite_pedagogique->photo) {
            Storage::disk('public')->delete($unite_pedagogique->photo);
            $unite_pedagogique->photo = null;
        }

        $unite_pedagogique->save();

        return redirect()
            ->route('admin.unites-pedagogiques.index')
            ->with('success', 'Unité pédagogique mise à jour avec succès.');
    }

    public function destroy(UnitePedagogique $unite_pedagogique): RedirectResponse
    {
        if ($unite_pedagogique->photo) {
            Storage::disk('public')->delete($unite_pedagogique->photo);
        }

        $unite_pedagogique->delete();

        return redirect()
            ->route('admin.unites-pedagogiques.index')
            ->with('success', 'Unité pédagogique supprimée.');
    }

    public function togglePublication(UnitePedagogique $unite_pedagogique): RedirectResponse
    {
        $unite_pedagogique->update(['est_publie' => ! $unite_pedagogique->est_publie]);

        return back()->with(
            'success',
            $unite_pedagogique->est_publie ? 'Unité publiée.' : 'Unité masquée du site public.'
        );
    }

    /* =====================================================
     |                    VALIDATION
     ===================================================== */

    private function rules(?UnitePedagogique $unite = null): array
    {
        return [
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('unites_pedagogiques', 'numero')->ignore($unite?->id),
            ],
            'titre' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'supprimer_photo' => ['nullable', 'boolean'],
            'concept' => ['required', 'string'],
            'objectif_general' => ['required', 'string'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'est_publie' => ['nullable', 'boolean'],

            'objectifs_specifiques' => ['nullable', 'array'],
            'objectifs_specifiques.*' => ['nullable', 'string', 'max:500'],

            'sous_unites' => ['nullable', 'array'],
            'sous_unites.*.nom' => ['nullable', 'string', 'max:255'],
            'sous_unites.*.etat' => ['nullable', 'string', 'max:100'],
            'sous_unites.*.apps' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Nettoie les tableaux (retire les lignes vides) et calcule le slug.
     * Ne gère pas le champ photo (traité séparément dans store/update pour le fichier).
     */
    private function prepareData(array $data, ?UnitePedagogique $unite = null): array
    {
        $objectifs = collect($data['objectifs_specifiques'] ?? [])
            ->map(fn($v) => trim((string) $v))
            ->filter()
            ->values()
            ->all();

        $sousUnites = collect($data['sous_unites'] ?? [])
            ->map(fn($su) => [
                'nom' => trim($su['nom'] ?? ''),
                'etat' => trim($su['etat'] ?? '') ?: null,
                'apps' => trim($su['apps'] ?? ''),
            ])
            ->filter(fn($su) => $su['nom'] !== '' || $su['apps'] !== '')
            ->values()
            ->all();

        return [
            'numero' => $data['numero'],
            'titre' => $data['titre'],
            'slug' => $unite?->slug ?? (Str::slug($data['titre']) . '-' . $data['numero']),
            'note' => $data['note'] ?? null,
            'concept' => $data['concept'],
            'objectif_general' => $data['objectif_general'],
            'objectifs_specifiques' => $objectifs,
            'sous_unites' => $sousUnites,
            'ordre' => $data['ordre'] ?? 0,
            'est_publie' => (bool) ($data['est_publie'] ?? false),
        ];
    }
}
