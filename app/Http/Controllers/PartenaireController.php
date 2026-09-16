<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PartenaireController extends Controller
{
    public function index(Request $request): View
    {
        $partenaires = Partenaire::when(
            $request->filled('recherche'),
            fn ($q) => $q->where('nom', 'LIKE', "%{$request->recherche}%")
                ->orWhere('type', 'LIKE', "%{$request->recherche}%")
        )
            ->orderBy('ordre_affichage')
            ->paginate(15)
            ->withQueryString();

        return view('admin.partenaires.index', compact('partenaires'));
    }

    public function create(): View
    {
        return view('admin.partenaires.create', [
            'prochainOrdre' => (Partenaire::max('ordre_affichage') ?? 0) + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePartenaire($request);

        if ($request->hasFile('logo_url')) {
            $validated['logo_url'] = 'partenaires/' . $this->storeLogo($request);
        }

        $validated['ordre_affichage'] = (Partenaire::max('ordre_affichage') ?? 0) + 1;

        Partenaire::create($validated);

        Cache::forget('partenaires.actifs');

        return redirect()
            ->route('admin.partenaires.index')
            ->with('status_partenaire', 'Partenaire créé avec succès.');
    }

    public function edit(Partenaire $partenaire): View
    {
        return view('admin.partenaires.edit', compact('partenaire'));
    }

    public function show(Partenaire $partenaire): View
    {
        return view('admin.partenaires.show', compact('partenaire'));
    }

    public function update(Request $request, Partenaire $partenaire): RedirectResponse
    {
        $validated = $this->validatePartenaire($request, $partenaire->id);

        if ($request->hasFile('logo_url')) {
            $oldLogo = $partenaire->logo_url;
            $validated['logo_url'] = 'partenaires/' . $this->storeLogo($request);
            $this->deleteLogo($oldLogo);
        }

        $newOrdre = (int) $request->input('ordre_affichage', $partenaire->ordre_affichage);

        if ($newOrdre !== $partenaire->ordre_affichage) {
            $conflict = Partenaire::where('id', '!=', $partenaire->id)
                ->where('ordre_affichage', $newOrdre)
                ->first();

            if ($conflict && !$request->boolean('confirmer_echange')) {
                return back()->withInput()->with('warning_echange', [
                    'message' => "L'ordre « {$newOrdre} » est déjà utilisé par « {$conflict->nom} ».",
                ]);
            }

            if ($conflict) {
                $ancienOrdre = $partenaire->ordre_affichage;
                $tmpOrdre = (Partenaire::max('ordre_affichage') ?? 0) + 5000;

                $conflict->update(['ordre_affichage' => $tmpOrdre]);
                $partenaire->update(['ordre_affichage' => $newOrdre]);
                $conflict->update(['ordre_affichage' => $ancienOrdre]);
            } else {
                $validated['ordre_affichage'] = $newOrdre;
            }
        }

        $partenaire->update($validated);

        Cache::forget('partenaires.actifs');

        return redirect()
            ->route('admin.partenaires.index')
            ->with('status_partenaire', 'Partenaire mis à jour avec succès.');
    }

    public function destroy(Partenaire $partenaire): RedirectResponse
    {
        $this->deleteLogo($partenaire->logo_url);

        $partenaire->delete();

        Cache::forget('partenaires.actifs');

        return redirect()
            ->route('admin.partenaires.index')
            ->with('status_partenaire', 'Partenaire supprimé.');
    }

    private function validatePartenaire(Request $request, ?int $ignoreId = null): array
    {
        $uniqueNom = 'unique:partenaires,nom';
        if ($ignoreId !== null) {
            $uniqueNom .= ',' . $ignoreId;
        }

        return $request->validate([
            'nom'          => ['required', 'string', 'max:150', $uniqueNom],
            'logo_url'     => ['nullable', 'image', 'mimes:jpeg,png,webp,gif', 'max:2048'],
            'site_web'     => ['nullable', 'url', 'max:255'],
            'type'         => ['required', 'string', 'in:institutionnel,financier,technique,academique,collectivite'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'actif'        => ['sometimes', 'boolean'],
        ], [
            'nom.unique'      => 'Ce nom est déjà utilisé.',
            'type.in'         => 'Le type sélectionné est invalide.',
            'logo_url.image'  => 'Le fichier doit être une image.',
            'logo_url.mimes'  => 'Formats autorisés : JPG, PNG, WEBP, GIF.',
        ]);
    }

    private function storeLogo(Request $request): string
    {
        $file = $request->file('logo_url');

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = 'partenaire_' . now()->format('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $extension;

        $file->move(public_path('partenaires'), $filename);

        return $filename;
    }

    private function deleteLogo(?string $logoUrl): void
    {
        if (!$logoUrl) {
            return;
        }

        $path = str_replace('partenaires/', '', $logoUrl);
        $fullPath = public_path('partenaires/' . $path);

        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}