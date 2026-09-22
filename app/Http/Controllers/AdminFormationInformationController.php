<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FormationInformation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminFormationInformationController extends Controller
{
    /**
     * Catégories valides et leur libellé lisible, utilisés pour
     * le select du formulaire et le regroupement dans la liste.
     */
    private const CATEGORIES = [
        'frais' => 'Frais annexes',
        'paiement_intermediaire' => 'Paiement — classes intermédiaires',
        'paiement_terminale' => 'Paiement — classes terminales',
        'dossier' => 'Composition du dossier',
    ];

    public function index()
    {
        $informations = FormationInformation::orderBy('categorie')
            ->orderBy('ordre')
            ->get()
            ->groupBy('categorie');

        return view('admin.formation-informations.index', [
            'informations' => $informations,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function create()
    {
        return view('admin.formation-informations.create', [
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        FormationInformation::create($data);

        return redirect()
            ->route('admin.formation-informations.index')
            ->with('success', 'Information ajoutée avec succès.');
    }

    public function edit(FormationInformation $formationInformation)
    {
        return view('admin.formation-informations.edit', [
            'information' => $formationInformation,
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, FormationInformation $formationInformation)
    {
        $data = $this->validated($request);

        $formationInformation->update($data);

        return redirect()
            ->route('admin.formation-informations.index')
            ->with('success', 'Information mise à jour avec succès.');
    }

    public function destroy(FormationInformation $formationInformation)
    {
        $formationInformation->delete();

        return redirect()
            ->route('admin.formation-informations.index')
            ->with('success', 'Information supprimée avec succès.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'categorie' => ['required', Rule::in(array_keys(self::CATEGORIES))],
            'libelle' => ['required', 'string', 'max:255'],
            'valeur' => ['nullable', 'string', 'max:255'],
            'ordre' => ['required', 'integer', 'min:0'],
        ]);
    }
}