<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\CategorieDocument;
use App\Models\CategorieFormation;
use App\Models\Document;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Idee;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Partenaire;
use App\Models\Personne;
use App\Models\Photo;
use App\Models\PieceInscription;
use App\Models\RechercheInnovation;
use App\Models\SessionFormation;
use App\Models\Temoignage;
use App\Models\TypePiece;
use App\Models\User;
use App\Models\Video;
use App\Models\Visite;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class StatistiqueFonctionnaliteController extends Controller
{
    private const PERIODES = ['jour', 'semaine', 'mois', 'trimestre', 'semestre', 'annuel'];

    /**
     * Vue d'ensemble chiffrée des fonctionnalités du site (contenus,
     * formations, inscriptions, utilisateurs…), filtrable par période
     * (jour, semaine, mois, trimestre, semestre, année).
     *
     * Le comptage s'appuie sur la date de création / soumission / publication
     * de chaque élément ; les téléchargements de documents sont comptés à leur
     * date réelle (journal des visites du centre de téléchargement). Les
     * référentiels sans date (matières, catégories de documents, partenaires)
     * restent affichés en total global.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Période + année
        |--------------------------------------------------------------------------
        */

        $periode = (string) request('periode', 'mois');
        if (! in_array($periode, self::PERIODES, true)) {
            $periode = 'mois';
        }

        $annees = $this->anneesProposees();
        $annee = (int) request('annee', now()->year);
        if (! in_array($annee, $annees, true)) {
            $annee = now()->year;
        }

        [$debut, $fin] = $this->bornes($periode, $annee);

        $periodes = [
            'jour' => "Aujourd'hui",
            'semaine' => 'Semaine',
            'mois' => 'Mois',
            'trimestre' => 'Trimestre',
            'semestre' => 'Semestre',
            'annuel' => 'Annuel',
        ];

        // Filtre réutilisable : éléments dont la date tombe dans la période.
        $dansPeriode = fn ($requete, string $colonne = 'created_at') =>
            $requete
                ->whereDate($colonne, '>=', $debut)
                ->whereDate($colonne, '<=', $fin);

        /*
        |--------------------------------------------------------------------------
        | Cartes récapitulatives (période courante)
        |--------------------------------------------------------------------------
        */

        $nbFormations   = (int) $dansPeriode(Formation::query())->count();
        $nbActualites   = (int) $dansPeriode(Actualite::query())->count();
        $nbDocuments    = (int) $dansPeriode(Document::query(), 'publie_le')->count();

        // Téléchargements réels du public (centre de téléchargement) : chaque
        // téléchargement est journalisé comme une visite « bibliotheque/…/telecharger »
        // avec sa vraie date. Compté sur la période choisie.
        $telechargements = fn () => Visite::query()
            ->where('page', 'like', 'bibliotheque/%/telecharger')
            ->whereBetween('date', [$debut, $fin]);
        $nbDocumentsTelecharges = (int) $telechargements()->distinct()->count('page');
        $nbTelechargementsPeriode = (int) $telechargements()->count();
        $nbInscriptions = (int) $dansPeriode(Inscription::query(), 'date_soumission')->count();
        $nbEnseignants  = (int) $dansPeriode(Enseignant::reels())->count();
        // Comptes hors super-admin (statistique globale).
        $nbUtilisateurs = (int) $dansPeriode(
            User::whereDoesntHave('roles', fn ($q) => $q->where('name', 'super-admin'))
        )->count();
        $nbGaleries     = (int) $dansPeriode(Photo::query())->count()
            + (int) $dansPeriode(Video::query())->count();
        $nbIdees        = (int) $dansPeriode(Idee::query())->count();

        $cartes = [
            ['libelle' => 'Formations',              'valeur' => $nbFormations,   'icone' => 'fa-graduation-cap',    'couleur' => 'primary',  'route' => 'admin.formations.index'],
            ['libelle' => 'Actualités',              'valeur' => $nbActualites,   'icone' => 'fa-newspaper',         'couleur' => 'danger',   'route' => 'admin.actualites.index'],
            ['libelle' => 'Documents téléchargés',   'valeur' => $nbTelechargementsPeriode, 'icone' => 'fa-download',        'couleur' => 'warning',  'route' => 'admin.documents.index'],
            ['libelle' => 'Inscriptions',            'valeur' => $nbInscriptions, 'icone' => 'fa-clipboard-list',    'couleur' => 'success',  'route' => 'admin.inscriptions.index'],
            ['libelle' => 'Enseignants',             'valeur' => $nbEnseignants,  'icone' => 'fa-chalkboard-teacher','couleur' => 'info',     'route' => 'admin.enseignants.index'],
            ['libelle' => 'Utilisateurs',            'valeur' => $nbUtilisateurs, 'icone' => 'fa-users',             'couleur' => 'secondary','route' => 'admin.user.index'],
            ['libelle' => 'Médias (photos & vidéos)','valeur' => $nbGaleries,     'icone' => 'fa-images',            'couleur' => 'teal',     'route' => 'admin.photos.index'],
            ['libelle' => 'Idées & suggestions',     'valeur' => $nbIdees,        'icone' => 'fa-lightbulb',         'couleur' => 'purple',   'route' => 'admin.idees.index'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Répartitions par fonctionnalité
        |--------------------------------------------------------------------------
        */

        $actualitesPubliees  = (int) $dansPeriode(Actualite::publiees())->count();
        $actualitesParType   = $dansPeriode(Actualite::query())
            ->selectRaw('type, COUNT(*) AS total')->groupBy('type')->pluck('total', 'type');

        $formationsParType   = $dansPeriode(Formation::query())
            ->selectRaw('type, COUNT(*) AS total')->groupBy('type')->pluck('total', 'type');
        $formationsParStatut = $dansPeriode(Formation::query())
            ->selectRaw('statut, COUNT(*) AS total')->groupBy('statut')->pluck('total', 'statut');

        $riPubliees          = (int) $dansPeriode(RechercheInnovation::publiees())->count();
        $riParType           = $dansPeriode(RechercheInnovation::query())
            ->selectRaw('type, COUNT(*) AS total')->groupBy('type')->pluck('total', 'type');

        $inscriptionsParStatut = $dansPeriode(Inscription::query(), 'date_soumission')
            ->selectRaw('statut, COUNT(*) AS total')->groupBy('statut')->pluck('total', 'statut');

        $ideesParStatut      = $dansPeriode(Idee::query())
            ->selectRaw('statut, COUNT(*) AS total')->groupBy('statut')->pluck('total', 'statut');

        $categoriesDocuments = CategorieDocument::withCount([
            'documents' => fn ($q) => $dansPeriode($q, 'publie_le'),
        ])
            ->orderByDesc('documents_count')
            ->limit(6)
            ->get();

        // Utilisateurs par rôle (rôles utilisés par le projet, hors super-admin).
        $roles = [
            'admin'       => 'Administrateur',
            'dg'          => 'Direction générale',
            'sg'          => 'Secrétariat général',
            'se'          => 'Service études',
            'sc'          => 'Service comptable',
            'enseignant'  => 'Enseignant',
            'user'        => 'Utilisateur',
        ];
        $utilisateursParRole = [];
        foreach ($roles as $code => $libelle) {
            $utilisateursParRole[$libelle] = (int) $dansPeriode(User::role($code))->count();
        }
        $utilisateursSansRole = (int) $dansPeriode(User::whereDoesntHave('roles'))->count();

        /*
        |--------------------------------------------------------------------------
        | Top 5 des documents les plus téléchargés (téléchargements réels)
        |--------------------------------------------------------------------------
        */

        $topTelechargements = $telechargements()
            ->selectRaw('page, COUNT(*) AS total')
            ->groupBy('page')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn ($v) => [
                preg_match('#^bibliotheque/([^/]+)/telecharger$#', (string) $v->page, $m) ? $m[1] : null,
                (int) $v->total,
            ])
            ->reject(fn ($i) => $i[0] === null)
            ->values();

        $topIds = $topTelechargements->pluck(0)->all();
        $titresDocs = $topIds ? Document::whereIn('id', $topIds)->pluck('titre', 'id') : collect();

        $topDocumentsTelecharges = $topTelechargements
            ->map(fn ($i) => [$titresDocs[$i[0]] ?? 'Document supprimé', $i[1]])
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Modules détaillés
        |--------------------------------------------------------------------------
        */

        $modules = [
            [
                'titre'   => 'Actualités',
                'icone'   => 'fa-newspaper',
                'couleur' => 'danger',
                'routes'  => [['Gérer les actualités', 'admin.actualites.index']],
                'lignes'  => [
                    ['Créées sur la période', $nbActualites],
                    ['Publiées', $actualitesPubliees],
                    ['Brouillons', max(0, $nbActualites - $actualitesPubliees)],
                ],
                'repartition' => [
                    'titre' => 'Par type',
                    'items' => [
                        ['Institutionnelle', (int) ($actualitesParType['institutionnelle'] ?? 0)],
                        ['Formation',        (int) ($actualitesParType['formation'] ?? 0)],
                        ['Événement',        (int) ($actualitesParType['evenement'] ?? 0)],
                        ['Partenariat',      (int) ($actualitesParType['partenariat'] ?? 0)],
                        ['Communiqué',       (int) ($actualitesParType['communique'] ?? 0)],
                    ],
                ],
            ],
            [
                'titre'   => 'Formations',
                'icone'   => 'fa-graduation-cap',
                'couleur' => 'primary',
                'routes'  => [['Gérer les formations', 'admin.formations.index']],
                'lignes'  => [
                    ['Créées sur la période', $nbFormations],
                    ['Ouvertes',  (int) ($formationsParStatut['ouverte'] ?? 0)],
                    ['Clôturées', (int) ($formationsParStatut['cloturee'] ?? 0)],
                    ['Brouillons',(int) ($formationsParStatut['brouillon'] ?? 0)],
                ],
                'repartition' => [
                    'titre' => 'Par type',
                    'items' => [
                        ['Académique',          (int) ($formationsParType['academique'] ?? 0)],
                        ['Continue Programmée', (int) ($formationsParType['continue_programmee'] ?? 0)],
                        ['Continue à la carte', (int) ($formationsParType['continue_a_la_carte'] ?? 0)],
                    ],
                ],
            ],
            [
                'titre'   => 'Recherches & innovations',
                'icone'   => 'fa-flask',
                'couleur' => 'info',
                'routes'  => [['Gérer les recherches/innovations', 'admin.recherches-innovations.index']],
                'lignes'  => [
                    ['Créées sur la période', (int) $dansPeriode(RechercheInnovation::query())->count()],
                    ['Publiées',  $riPubliees],
                    ['Brouillons', max(0, (int) $dansPeriode(RechercheInnovation::query())->count() - $riPubliees)],
                ],
                'repartition' => [
                    'titre' => 'Par type',
                    'items' => [
                        ['Recherche',  (int) ($riParType['recherche'] ?? 0)],
                        ['Innovation', (int) ($riParType['innovation'] ?? 0)],
                    ],
                ],
            ],
            [
                'titre'   => 'Pédagogie (départements)',
                'icone'   => 'fa-book-open',
                'couleur' => 'teal',
                'routes'  => [
                    ['Filières', 'admin.filieres.index'],
                    ['Sessions de formation', 'admin.sessions-formation.index'],
                    ['Enseignants', 'admin.enseignants.index'],
                    ['Matières', 'admin.matieres.index'],
                ],
                'lignes'  => [
                    ['Filières créées', (int) $dansPeriode(Filiere::query())->count()],
                    ['Filières actives', (int) $dansPeriode(Filiere::active())->count()],
                    ['Catégories de formation créées', (int) $dansPeriode(CategorieFormation::query())->count()],
                    ['Sessions de formation créées', (int) $dansPeriode(SessionFormation::query())->count()],
                    ['Sessions ouvertes', (int) $dansPeriode(SessionFormation::ouvertes())->count()],
                    ['Enseignants', $nbEnseignants],
                    ['Enseignants actifs', (int) $dansPeriode(Enseignant::reels()->actifs())->count()],
                    ['Notes déposées', (int) $dansPeriode(Note::query())->count()],
                ],
                'referentiels_globaux' => [
                    ['Matières', (int) Matiere::count()],
                ],
            ],
            [
                'titre'   => 'Inscriptions & candidatures',
                'icone'   => 'fa-clipboard-list',
                'couleur' => 'success',
                'routes'  => [['Gérer les inscriptions', 'admin.inscriptions.index']],
                'lignes'  => [
                    ['Soumises sur la période', $nbInscriptions],
                    ['Pièces déposées', (int) $dansPeriode(PieceInscription::query())->count()],
                ],
                'repartition' => [
                    'titre' => 'Par statut du dossier',
                    'items' => [
                        ['Déposé',    (int) ($inscriptionsParStatut['depose'] ?? 0)],
                        ['En cours',  (int) ($inscriptionsParStatut['en_cours'] ?? 0)],
                        ['Incomplet', (int) ($inscriptionsParStatut['incomplet'] ?? 0)],
                        ['Validé',    (int) ($inscriptionsParStatut['valide'] ?? 0)],
                        ['Rejeté',    (int) ($inscriptionsParStatut['rejete'] ?? 0)],
                    ],
                ],
            ],
            [
                'titre'   => 'Bibliothèque des documents',
                'icone'   => 'fa-file-pdf',
                'couleur' => 'warning',
                'routes'  => [
                    ['Gérer les documents', 'admin.documents.index'],
                    ['Catégories de documents', 'admin.categories-documents.index'],
                ],
                'lignes'  => [
                    ['Publiés sur la période', $nbDocuments],
                    ['Documents téléchargés (public)', $nbDocumentsTelecharges],
                    ['Téléchargements effectués', $nbTelechargementsPeriode],
                ],
                'repartition' => [
                    'titre' => 'Documents publiés par catégorie (top 6)',
                    'items' => $categoriesDocuments
                        ->map(fn ($c) => [$c->nom, (int) $c->documents_count])
                        ->values()
                        ->toArray(),
                    'vide' => 'Aucun document publié sur la période.',
                ],
                'top' => [
                    'titre' => 'Top 5 des documents les plus téléchargés',
                    'items' => $topDocumentsTelecharges,
                    'vide'  => 'Aucun téléchargement sur la période.',
                ],
            ],
            [
                'titre'   => 'Médias & témoignages',
                'icone'   => 'fa-images',
                'couleur' => 'purple',
                'routes'  => [
                    ['Galerie photos', 'admin.photos.index'],
                    ['Galerie vidéos', 'admin.videos.index'],
                    ['Témoignages', 'admin.temoignages.index'],
                    ['Partenaires', 'admin.partenaires.index'],
                ],
                'lignes'  => [
                    ['Photos ajoutées', (int) $dansPeriode(Photo::query())->count()],
                    ['Photos visibles', (int) $dansPeriode(Photo::where('est_visible', true))->count()],
                    ['Vidéos ajoutées', (int) $dansPeriode(Video::query())->count()],
                    ['Vidéos visibles', (int) $dansPeriode(Video::where('est_visible', true))->count()],
                    ['Témoignages', (int) $dansPeriode(Temoignage::query())->count()],
                    ['Témoignages publiés', (int) $dansPeriode(Temoignage::publies())->count()],
                ],
                'referentiels_globaux' => [
                    ['Partenaires', (int) Partenaire::count()],
                ],
            ],
            [
                'titre'   => 'Boite à idées',
                'icone'   => 'fa-lightbulb',
                'couleur' => 'maroon',
                'routes'  => [['Gérer les idées', 'admin.idees.index']],
                'lignes'  => [
                    ['Soumises sur la période', $nbIdees],
                ],
                'repartition' => [
                    'titre' => 'Par statut',
                    'items' => [
                        ['Soumise',     (int) ($ideesParStatut['soumise'] ?? 0)],
                        ['En étude',    (int) ($ideesParStatut['en_etude'] ?? 0)],
                        ['Acceptée',    (int) ($ideesParStatut['acceptee'] ?? 0)],
                        ['Réalisée',    (int) ($ideesParStatut['realisee'] ?? 0)],
                        ['Non retenue', (int) ($ideesParStatut['refusee'] ?? 0)],
                    ],
                ],
            ],
            [
                'titre'   => 'Utilisateurs',
                'icone'   => 'fa-users',
                'couleur' => 'secondary',
                'routes'  => [['Gérer les utilisateurs', 'admin.user.index']],
                'lignes'  => [
                    ['Comptes créés', $nbUtilisateurs],
                    ['Sans rôle', $utilisateursSansRole],
                ],
                'repartition' => [
                    'titre' => 'Par rôle',
                    'items' => array_map(
                        fn ($libelle) => [$libelle, $utilisateursParRole[$libelle]],
                        array_keys($utilisateursParRole)
                    ),
                ],
            ],
            [
                'titre'   => 'Pièces',
                'icone'   => 'fa-cogs',
                'couleur' => 'navy',
                'routes'  => [
                    ['Types de pièces', 'admin.types-pieces.index'],
                    ['Catégories de formation', 'admin.categories-formation.index'],
                ],
                'lignes'  => [
                    ['Types de pièces créés', (int) $dansPeriode(TypePiece::query())->count()],
                    ['Types de pièces actifs', (int) $dansPeriode(TypePiece::actifs())->count()],
                    ['Types de pièces obligatoires', (int) $dansPeriode(TypePiece::obligatoires())->count()],
                ],
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Graphiques
        |--------------------------------------------------------------------------
        */

        $chartContenus = [
            'labels'   => [
                'Formations', 'Actualités', 'Documents', 'Inscriptions',
                'Recherches', 'Photos', 'Vidéos',
                'Témoignages', 'Filières', 'Idées',
            ],
            'donnees'  => [
                $nbFormations, $nbActualites, $nbDocuments, $nbInscriptions,
                (int) $dansPeriode(RechercheInnovation::query())->count(),
                (int) $dansPeriode(Photo::query())->count(),
                (int) $dansPeriode(Video::query())->count(),
                (int) $dansPeriode(Temoignage::query())->count(),
                (int) $dansPeriode(Filiere::query())->count(),
                $nbIdees,
            ],
        ];

        $couleursRoles = ['#3c8dbc', '#00a65a', '#f39c12', '#dd4b39', '#00c0ef', '#605ca8', '#f012be', '#39cccc', '#6c757d'];
        $chartRoles = [
            'labels'  => [],
            'donnees' => [],
            'couleurs' => [],
        ];
        $i = 0;
        foreach ($roles as $code => $libelle) {
            if (($utilisateursParRole[$libelle] ?? 0) > 0) {
                $chartRoles['labels'][] = $libelle;
                $chartRoles['donnees'][] = $utilisateursParRole[$libelle];
                $chartRoles['couleurs'][] = $couleursRoles[$i % count($couleursRoles)];
                $i++;
            }
        }

        return view(
            'admin.statistiques.fonctionnalites',
            compact(
                'periodes',
                'periode',
                'annees',
                'annee',
                'debut',
                'fin',
                'cartes',
                'modules',
                'chartContenus',
                'chartRoles'
            )
        );
    }

    /**
     * Années proposées dans le sélecteur : de la plus ancienne donnée
     * (au plus tôt il y a 3 ans) à l'année en cours.
     */
    private function anneesProposees(): array
    {
        $tables = [
            [Actualite::class, 'created_at'],
            [Formation::class, 'created_at'],
            [RechercheInnovation::class, 'created_at'],
            [Inscription::class, 'date_soumission'],
            [Document::class, 'publie_le'],
            [Idee::class, 'created_at'],
            [User::class, 'created_at'],
            [Enseignant::class, 'created_at'],
            [Photo::class, 'created_at'],
            [Video::class, 'created_at'],
            [Temoignage::class, 'created_at'],
            [Filiere::class, 'created_at'],
            [SessionFormation::class, 'created_at'],
            [PieceInscription::class, 'created_at'],
        ];

        $anneeMin = now()->year;

        foreach ($tables as [$modele, $colonne]) {
            $annee = (int) ($modele::query()
                ->selectRaw('MIN(EXTRACT(YEAR FROM ' . $colonne . ')) AS annee')
                ->value('annee') ?? 0);

            if ($annee > 0) {
                $anneeMin = min($anneeMin, $annee);
            }
        }

        return range(min(now()->year - 2, $anneeMin), now()->year);
    }

    /**
     * Bornes d'une période, dans l'année choisie.
     * - Année courante : période arrêtée à aujourd'hui.
     * - Années antérieures : même période calendaire complète dans cette année.
     */
    private function bornes(string $periode, int $annee): array
    {
        $maintenant = now();

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
}
