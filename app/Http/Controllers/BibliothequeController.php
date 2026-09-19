<?php

namespace App\Http\Controllers;

use App\Models\CategorieDocument;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BibliothequeController extends Controller
{
    private array $typeLabels = [
        'rapport' => 'Rapport',
        'brochure' => 'Brochure',
        'texte_reglementaire' => 'Texte réglementaire',
        'support_pedagogique' => 'Support pédagogique',
    ];

    public function index(Request $request): View
    {
        $categories = CategorieDocument::all();

        $documents = Document::with('categorie')
            ->where('acces', 'public')
            ->when($request->filled('categorie_id'), function ($query) use ($request) {
                $query->where('categorie_id', $request->categorie_id);
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('titre', 'ilike', '%' . $request->q . '%');
            })
            ->orderByDesc('publie_le')
            ->paginate(12)
            ->withQueryString();

        return view('bibliotheque.index', [
            'documents' => $documents,
            'categories' => $categories,
            'typeLabels' => $this->typeLabels,
        ]);
    }

    public function telecharger(Document $document)
    {
        if ($document->acces !== 'public') {
            return redirect()
                ->route('bibliotheque.index')
                ->with('info', 'Ce document n\'est pas téléchargeable en ligne. Rendez-vous à la bibliothèque de l\'ENEF (Bobo-Dioulasso) pour consulter sa version physique.');
        }

        $document->increment('nombre_telechargements');

        return redirect($document->fichier_url);
    }
}
