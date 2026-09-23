<?php

namespace App\Http\Controllers;

use App\Models\CategorieDocument;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BibliothequeController extends Controller
{
    private array $typeOptions = [
        'rapport' => 'Rapport',
        'brochure' => 'Brochure',
        'texte_reglementaire' => 'Texte réglementaire',
        'support_pedagogique' => 'Support pédagogique',
    ];

    public function telechargeables(Request $request): View
    {
        $categories = CategorieDocument::orderBy('nom')->get();

        $documents = $this->baseQuery($request)
            ->where('telechargeable', true)
            ->orderByDesc('publie_le')
            ->paginate(12)
            ->withQueryString();

        return view('bibliotheque.telechargeables', [
            'documents' => $documents,
            'categories' => $categories,
            'typeOptions' => $this->typeOptions,
        ]);
    }

    public function consultation(Request $request): View
    {
        $categories = CategorieDocument::orderBy('nom')->get();

        $documents = $this->baseQuery($request)
            ->where('telechargeable', false)
            ->orderByDesc('publie_le')
            ->paginate(12)
            ->withQueryString();

        return view('bibliotheque.consultation', [
            'documents' => $documents,
            'categories' => $categories,
            'typeOptions' => $this->typeOptions,
        ]);
    }

    private function baseQuery(Request $request)
    {
        return Document::with('categorie')
            ->where('acces', 'public')
            ->when($request->filled('categorie_id'), fn ($q) => $q->where('categorie_id', $request->categorie_id))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('titre', 'like', '%' . $request->q . '%')
                        ->orWhere('description', 'like', '%' . $request->q . '%');
                });
            });
    }
}