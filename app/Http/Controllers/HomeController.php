<?php

namespace App\Http\Controllers;

use App\Models\ParametresSite;
use App\Models\Temoignage;
use App\Models\Filiere;
use App\Models\CategorieFormation;
use App\Models\Formation;
use App\Models\Actualite;
use App\Models\CategorieDocument;
use App\Models\Document;
use App\Models\Partenaire;
use App\Models\SessionFormation;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $paramSite = Cache::remember('site.parametres', now()->addHours(6), function () {
            return ParametresSite::first();
        });

        $categories = Cache::remember('formations.categories', now()->addHours(6), function () {
            return CategorieFormation::all();
        });

        $fillieres = Cache::remember('filieres.actives', now()->addHours(6), function () {
            return Filiere::active()->get();
        });

        // $temoignages = Temoignage::publies()->ordonnes()->get();
        $temoignages = Temoignage::publies()->orderBy('ordre')->get();

        $formations = Formation::ouvertes()
            ->with([
                'filiere',
                'categorie',
                'sessions' => fn($query) => $query
                    ->where('statut', 'ouverte')
                    ->where('date_debut', '>=', now())
                    ->orderBy('date_debut'),
            ])
            ->get();

        $actualites = Actualite::publiees()->latest()->limit(10)->get();
        $derniereActualite = $actualites->first();

        $sessions = SessionFormation::with('formation')
            ->where('statut', 'ouverte')
            ->where('date_debut', '>=', now())
            ->where('places_disponibles', '>', 0)
            ->orderBy('date_debut')
            ->limit(6)
            ->get();

        $categoriesDocuments = CategorieDocument::all();

        $documentsRecents = Document::with('categorie')
            ->orderByDesc('publie_le')
            ->take(4)
            ->get();

        $biblioStats = [
            'documents' => Document::count(),
            'annees' => Document::whereNotNull('publie_le')
                ->selectRaw('EXTRACT(YEAR FROM publie_le) as annee')
                ->distinct()
                ->get()
                ->count(),
            'thematiques' => CategorieDocument::all()->count(),
        ];

        $typeLabels = [
            'rapport' => 'Rapport',
            'brochure' => 'Brochure',
            'texte_reglementaire' => 'Texte réglementaire',
            'support_pedagogique' => 'Support pédagogique',
        ];

        $partenaires = Cache::remember('partenaires.actifs', now()->addHours(6), function () {
            return Partenaire::actifs()->ordonnes()->get();
        });

        $formationsInitiales = Formation::whereNotIn('type', ['continue_programmee', 'continue_a_la_carte'])
    ->orderByRaw("CASE WHEN code_module LIKE 'FI-GRN%' THEN 0 ELSE 1 END")
    ->orderBy('code_module')
    ->get();

        return view('welcome', [
            'param_site'          => $paramSite,
            'temoignages'         => $temoignages,
            'fillieres'           => $fillieres,
            'categories'          => $categories,
            'formation'           => $formations,
            'actualites'          => $actualites,
            'derniereActualite'   => $derniereActualite,
            'sessions'            => $sessions,
            'categoriesDocuments' => $categoriesDocuments,
            'documentsRecents'    => $documentsRecents,
            'biblioStats'         => $biblioStats,
            'typeLabels'          => $typeLabels,
            'partenaires'         => $partenaires,
            'formationsInitiales' =>$formationsInitiales,
            
        ]);


    }

    public function mentionLegale()
    {
        return view('mentions-legales');
    }

    // Mot du Directeur
    public function motDuDirecteur()
    {
        $param_site = ParametresSite::first();

        return view('mot_directeur.index', [
            'param_site' => $param_site,
        ]);
    }

    // Unites Pedagogiques
    public function unitesPedagogiques()
    {
        return view('unites-pedagogiques.index');
    }
}
