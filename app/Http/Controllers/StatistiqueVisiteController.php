<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class StatistiqueVisiteController extends Controller
{
    private const PERIODES = ['jour', 'semaine', 'mois', 'trimestre', 'semestre', 'annuel'];

    /**
     * Page admin : fréquentation du site public, pages visitées et lieux des visiteurs,
     * filtrable par période (jour, semaine, mois, trimestre, semestre, année).
     */
    public function index(): View
    {
        $periode = (string) request('periode', 'mois');
        if (! in_array($periode, self::PERIODES, true)) {
            $periode = 'mois';
        }

        // Années proposées : de la plus ancienne avec des visites (au plus tôt il y a 3 ans)
        // à l'année en cours.
        $anneePremiere = (int) (Visite::query()
            ->selectRaw('MIN(EXTRACT(YEAR FROM date)) AS annee')
            ->value('annee') ?? 0);
        $annees = range(min(now()->year - 2, $anneePremiere ?: now()->year), now()->year);
        $annee = (int) request('annee', now()->year);
        if (! in_array($annee, $annees, true)) {
            $annee = now()->year;
        }

        [$debut, $fin] = $this->bornes($periode, $annee);

        // Cartes de synthèse.
        $synthese = Visite::query()
            ->whereBetween('date', [$debut, $fin])
            ->selectRaw(
                'COUNT(*) AS vues, '
                . 'COUNT(DISTINCT session_id) AS visiteurs, '
                . 'COUNT(DISTINCT page) AS pages'
            )
            ->first();

        // Pages visitées (5 par page) — un même visiteur ne compte qu'une fois par jour.
        $pages = Visite::query()
            ->fromSub(
                Visite::query()
                    ->whereBetween('date', [$debut, $fin])
                    ->selectRaw('page, date, COUNT(*) AS vues_jour, COUNT(DISTINCT session_id) AS visiteurs_jour')
                    ->groupBy('date', 'page'),
                'par_jour'
            )
            ->selectRaw('page, SUM(vues_jour) AS vues, SUM(visiteurs_jour) AS visiteurs')
            ->groupBy('page')
            ->orderByDesc('vues')
            ->paginate(5)
            ->withQueryString()
            ->fragment('tableaux-visiteurs');

        // Top 10 des pages les plus visitées sur la période.
        $topPages = Visite::query()
            ->whereBetween('date', [$debut, $fin])
            ->selectRaw('page, COUNT(*) AS vues, COUNT(DISTINCT session_id) AS visiteurs')
            ->groupBy('page')
            ->orderByDesc('vues')
            ->limit(10)
            ->get();

        // Lieux des visiteurs (ville / pays, 5 par page) — un même visiteur ne
        // compte qu'une fois par jour : on agrège les visiteurs uniques de
        // chaque journée par lieu, puis on additionne les journées.
        $lieuxTous = Visite::query()
            ->whereBetween('date', [$debut, $fin])
            ->selectRaw(
                "COALESCE(NULLIF(ville, ''), '—') AS ville, "
                . "COALESCE(NULLIF(pays, ''), 'Non déterminé') AS pays, "
                . "COALESCE(NULLIF(pays_code, ''), '—') AS pays_code, "
                . 'COUNT(DISTINCT session_id) AS visiteurs_jour'
            )
            ->groupBy('date', 'ville', 'pays', 'pays_code')
            ->get()
            ->groupBy(fn ($ligne) => $ligne->ville . "\x1F" . $ligne->pays . "\x1F" . $ligne->pays_code)
            ->map(function ($groupe) {
                $premier = $groupe->first();

                return (object) [
                    'ville' => $premier->ville,
                    'pays' => $premier->pays,
                    'pays_code' => $premier->pays_code,
                    'visiteurs' => (int) $groupe->sum('visiteurs_jour'),
                ];
            })
            ->sortByDesc('visiteurs')
            ->values();

        $nbLieux = $lieuxTous->count();
        $pageLieux = max(1, (int) request('lieux_page', 1));
        $lieux = new LengthAwarePaginator(
            $lieuxTous->forPage($pageLieux, 5)->values(),
            $nbLieux,
            5,
            $pageLieux,
            ['path' => request()->url(), 'query' => request()->query(), 'fragment' => 'tableaux-visiteurs']
        );
        $lieux->setPageName('lieux_page');

        // Série pour le graphe (journalière, re-découpée selon la période).
        $journalier = Visite::query()
            ->whereBetween('date', [$debut, $fin])
            ->selectRaw('date, COUNT(*) AS vues, COUNT(DISTINCT session_id) AS visiteurs')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(fn ($ligne) => $ligne->date->toDateString());

        $graphique = $this->serie(
            $periode,
            Carbon::parse($debut),
            Carbon::parse($fin),
            $journalier
        );

        $periodes = [
            'jour' => "Aujourd'hui",
            'semaine' => 'Semaine',
            'mois' => 'Mois',
            'trimestre' => 'Trimestre',
            'semestre' => 'Semestre',
            'annuel' => 'Annuel',
        ];

        $titres = [
            'jour' => 'Visites horaires du jour',
            'semaine' => 'Visites journalières de la semaine',
            'mois' => 'Visites journalières du mois',
            'trimestre' => 'Visites hebdomadaires du trimestre',
            'semestre' => 'Visites mensuelles du semestre',
            'annuel' => 'Visites mensuelles de l’année',
        ];

        return view('admin.statistiques.visiteurs', compact(
            'periode',
            'periodes',
            'titres',
            'annee',
            'annees',
            'synthese',
            'pages',
            'topPages',
            'lieux',
            'nbLieux',
            'graphique'
        ));
    }

    private function bornes(string $periode, int $annee): array
    {
        $maintenant = now();

        // Année courante : bornes identiques à avant (jusqu'à aujourd'hui).
        if ($annee === $maintenant->year) {
            return match ($periode) {
                'jour' => [$maintenant->copy()->startOfDay()->toDateString(), $maintenant->toDateString()],
                'semaine' => [$maintenant->copy()->startOfWeek()->toDateString(), $maintenant->toDateString()],
                'mois' => [$maintenant->copy()->startOfMonth()->toDateString(), $maintenant->toDateString()],
                'trimestre' => [$maintenant->copy()->startOfQuarter()->toDateString(), $maintenant->toDateString()],
                'semestre' => $maintenant->month <= 6
                    ? [$maintenant->copy()->startOfYear()->toDateString(), $maintenant->toDateString()]
                    : [$maintenant->copy()->startOfYear()->addMonths(6)->toDateString(), $maintenant->toDateString()],
                'annuel' => [$maintenant->copy()->startOfYear()->toDateString(), $maintenant->toDateString()],
            };
        }

        // Années antérieures : même période calendaire dans cette année, complète.
        $jourDuMois = min($maintenant->day, Carbon::create($annee, $maintenant->month, 1)->daysInMonth);
        $ref = Carbon::create($annee, $maintenant->month, $jourDuMois);

        return match ($periode) {
            'jour' => [$ref->copy()->startOfDay()->toDateString(), $ref->copy()->endOfDay()->toDateString()],
            'semaine' => [$ref->copy()->startOfWeek()->toDateString(), $ref->copy()->endOfWeek()->toDateString()],
            'mois' => [$ref->copy()->startOfMonth()->toDateString(), $ref->copy()->endOfMonth()->toDateString()],
            'trimestre' => [$ref->copy()->startOfQuarter()->toDateString(), $ref->copy()->endOfQuarter()->toDateString()],
            'semestre' => $ref->month <= 6
                ? [$ref->copy()->startOfYear()->toDateString(), $ref->copy()->startOfYear()->addMonths(6)->subDay()->toDateString()]
                : [$ref->copy()->startOfYear()->addMonths(6)->toDateString(), $ref->copy()->endOfYear()->toDateString()],
            'annuel' => [$ref->copy()->startOfYear()->toDateString(), $ref->copy()->endOfYear()->toDateString()],
        };
    }

    private function serie(string $periode, Carbon $debut, Carbon $fin, Collection $journalier): array
    {
        $cleJour = function (Carbon $jour) use ($journalier): array {
            $donnees = $journalier->get($jour->toDateString());

            return [(int) ($donnees->vues ?? 0), (int) ($donnees->visiteurs ?? 0)];
        };

        return match ($periode) {
            'jour' => $this->horaire($fin),
            'trimestre' => $this->hebdomadaire($debut, $fin, $cleJour),
            'semestre', 'annuel' => $this->mensuelle($debut, $fin, $cleJour),
            default => $this->quotidienne($debut, $fin, $cleJour),
        };
    }

    private function horaire(Carbon $jour): array
    {
        $parHeure = Visite::query()
            ->whereDate('visite_a', $jour->toDateString())
            ->selectRaw(
                'EXTRACT(HOUR FROM visite_a) AS heure, '
                . 'COUNT(*) AS vues, COUNT(DISTINCT session_id) AS visiteurs'
            )
            ->groupByRaw('EXTRACT(HOUR FROM visite_a)')
            ->orderByRaw('EXTRACT(HOUR FROM visite_a)')
            ->get()
            ->keyBy('heure');

        $labels = [];
        $vues = [];
        $visiteurs = [];

        for ($h = 0; $h <= 23; $h++) {
            $labels[] = str_pad((string) $h, 2, '0', STR_PAD_LEFT) . 'h';
            $donnees = $parHeure->get($h);
            $vues[] = (int) ($donnees->vues ?? 0);
            $visiteurs[] = (int) ($donnees->visiteurs ?? 0);
        }

        return compact('labels', 'vues', 'visiteurs');
    }

    private function quotidienne(Carbon $debut, Carbon $fin, callable $cleJour): array
    {
        $labels = [];
        $vues = [];
        $visiteurs = [];
        $jour = $debut->copy();

        while ($jour->lte($fin)) {
            [$v, $u] = $cleJour($jour);
            $labels[] = $jour->format('d/m');
            $vues[] = $v;
            $visiteurs[] = $u;
            $jour->addDay();
        }

        return compact('labels', 'vues', 'visiteurs');
    }

    private function hebdomadaire(Carbon $debut, Carbon $fin, callable $cleJour): array
    {
        $labels = [];
        $vues = [];
        $visiteurs = [];
        $debutSemaine = $debut->copy()->startOfWeek();

        while ($debutSemaine->lte($fin)) {
            $finSemaine = $debutSemaine->copy()->addDays(6);
            $totalV = 0;
            $totalU = 0;
            $jour = $debutSemaine->copy();

            while ($jour->lte($finSemaine) && $jour->lte($fin)) {
                [$v, $u] = $cleJour($jour);
                $totalV += $v;
                $totalU += $u;
                $jour->addDay();
            }

            $labels[] = 'Du ' . $debutSemaine->format('d/m/y');
            $vues[] = $totalV;
            $visiteurs[] = $totalU;
            $debutSemaine = $finSemaine->copy()->addDay();
        }

        return compact('labels', 'vues', 'visiteurs');
    }

    private function mensuelle(Carbon $debut, Carbon $fin, callable $cleJour): array
    {
        $labels = [];
        $vues = [];
        $visiteurs = [];
        $mois = $debut->copy()->startOfMonth();

        while ($mois->lte($fin)) {
            $finMois = $mois->copy()->endOfMonth();
            $totalV = 0;
            $totalU = 0;
            $jour = $mois->copy();

            while ($jour->lte($finMois) && $jour->lte($fin)) {
                [$v, $u] = $cleJour($jour);
                $totalV += $v;
                $totalU += $u;
                $jour->addDay();
            }

            $labels[] = $mois->format('m/Y');
            $vues[] = $totalV;
            $visiteurs[] = $totalU;
            $mois->addMonth();
        }

        return compact('labels', 'vues', 'visiteurs');
    }
}