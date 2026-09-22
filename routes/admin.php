<?php

use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\CategorieDocumentController;
use App\Http\Controllers\CategorieFormationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\IdeeController;
use App\Http\Controllers\IdeeDirectionController;
use App\Http\Controllers\InscriptionAdminController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\MesTemoignagesController;
use App\Http\Controllers\NoteAdminController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ParametresSiteController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PhotoAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SessionFormationController;
use App\Http\Controllers\TemoignageController;
use App\Http\Controllers\TypePieceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoAdminController;
use App\Http\Controllers\RechercheInnovationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    // ==================== DASHBOARD ====================

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/dashboard/chart-data', [ProfileController::class, 'getChartData'])
        ->name('dashboard.chart-data');


    // ==================== PROFIL ====================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // ==================== UTILISATEURS ====================

    Route::resource('users', UserController::class)
        ->names('user');

    Route::get('/users/stats', [UserController::class, 'stats'])
        ->name('user.stats');


    // ==================== RÔLES ET PERMISSIONS ====================

    Route::middleware(['role:Gérant'])->group(function () {

        Route::resource('role', RoleController::class);

        Route::resource('permission', PermissionController::class);
    });


    // ==================== ACTUALITÉS ====================

    Route::prefix('actualites')->name('actualites.')->group(function () {

        // Liste des actualités
        Route::get('/', [ActualiteController::class, 'adminIndex'])
            ->name('index');

        // Formulaire de création
        Route::get('/create', [ActualiteController::class, 'create'])
            ->name('create');

        // Enregistrer une actualité
        Route::post('/', [ActualiteController::class, 'store'])
            ->name('store');

        // Formulaire de modification
        Route::get('/{actualite}/edit', [ActualiteController::class, 'edit'])
            ->name('edit');

        // Modifier une actualité
        Route::put('/{actualite}', [ActualiteController::class, 'update'])
            ->name('update');

        // Supprimer une actualité
        Route::delete('/{actualite}', [ActualiteController::class, 'destroy'])
            ->name('destroy');

        // Publier une actualité
        Route::patch('/{actualite}/publier', [ActualiteController::class, 'publier'])
            ->name('publier');

        // Dépublier une actualité
        Route::patch('/{actualite}/depublier', [ActualiteController::class, 'depublier'])
            ->name('depublier');
    });


    // ==================== BIBLIOTHÈQUE DOCUMENTAIRE ====================

    Route::prefix('documents')->name('documents.')->group(function () {

        Route::get('/', [DocumentController::class, 'index'])
            ->name('index');

        // ⚠️ Routes littérales AVANT la route dynamique /{document} :
        // sinon "create" est capturé comme valeur de {document}.
        Route::get('/create', [DocumentController::class, 'create'])
            ->name('create');

        Route::post('/', [DocumentController::class, 'store'])
            ->name('store');

        Route::get('/{document}/edit', [DocumentController::class, 'edit'])
            ->name('edit');

        Route::get('/{document}', [DocumentController::class, 'show'])
            ->name('show');

        Route::put('/{document}', [DocumentController::class, 'update'])
            ->name('update');

        Route::delete('/{document}', [DocumentController::class, 'destroy'])
            ->name('destroy');

        Route::get('/{document}/telecharger', [DocumentController::class, 'telecharger'])->name('telecharger');
    });


    // ==================== CATÉGORIES DOCUMENTS ====================

    // Route::prefix('categories-documents')->name('categories-documents.')->group(function () {

    //     Route::get('/', [CategorieDocumentController::class, 'index'])
    //         ->name('index');

    //     Route::post('/', [CategorieDocumentController::class, 'store'])
    //         ->name('store');

    //     Route::get('/{categorie}', [CategorieDocumentController::class, 'show'])
    //         ->name('show');

    //     Route::put('/{categorie}', [CategorieDocumentController::class, 'update'])
    //         ->name('update');

    //     Route::delete('/{categorie}', [CategorieDocumentController::class, 'destroy'])
    //         ->name('destroy');
    // });


    // ==================== PARAMÈTRES DU SITE ====================

    Route::get('parametres/public', [ParametresSiteController::class, 'getPublicSettings'])
        ->name('parametres.public');

    Route::prefix('parametres')->name('parametres.')->group(function () {

        Route::get('/', [ParametresSiteController::class, 'index'])
            ->name('index');

        Route::get('/{parametre}', [ParametresSiteController::class, 'show'])
            ->name('show');

        Route::post('/', [ParametresSiteController::class, 'store'])
            ->name('store');

        Route::put('/{parametre}', [ParametresSiteController::class, 'update'])
            ->name('update');

        Route::delete('/{parametre}', [ParametresSiteController::class, 'destroy'])
            ->name('destroy');
    });


    // ==================== INSCRIPTIONS CANDIDATS ====================

    Route::name('inscription.')->group(function () {

        // Choisir une session de formation
        Route::get(
            'inscription/choisir',
            [InscriptionController::class, 'create']
        )->name('create');

        // Formulaire d'inscription à une session
        Route::get(
            'inscription/session/{session}',
            [InscriptionController::class, 'createforme']
        )->name('inscriptionforme');

        // Détails d'une candidature
        Route::get(
            'inscription/{inscription}',
            [InscriptionController::class, 'show']
        )->name('show');

        // Enregistrer une candidature
        Route::post(
            'inscription',
            [InscriptionController::class, 'store']
        )->name('store');

        // Ajouter une pièce à une candidature
        Route::post(
            'inscription/{inscription}/pieces',
            [InscriptionController::class, 'storePiece']
        )->name('piece.store');

        // Télécharger une pièce
        Route::get(
            'pieces/{piece}/telecharger',
            [InscriptionController::class, 'telechargerPiece']
        )->name('piece.telecharger');

        // Modifier une pièce
        Route::put(
            '/inscription/piece/{piece}',
            [InscriptionController::class, 'updatePiece']
        )->name('piece.update');

        // Supprimer une pièce
        Route::delete(
            'pieces/{piece}',
            [InscriptionController::class, 'destroyPiece']
        )->name('piece.destroy');
    });


    // ==================== FORMATIONS ====================

    Route::resource('formations', FormationController::class)
        ->names('formations');

    Route::patch(
        'formations/{formation}/statut',
        [FormationController::class, 'changerStatut']
    )->name('formations.statut');


    // ==================== ENSEIGNANTS ====================

    Route::resource('enseignants', EnseignantController::class)
        ->except(['show'])
        ->names('enseignants');


    // ==================== FILIÈRES ====================

    Route::resource('filieres', FiliereController::class)
        ->except(['show'])
        ->names('filieres');



    // ==================== NOTES (ENSEIGNANT) ====================

    Route::prefix('enseignant')
        ->name('enseignant.')
        ->middleware(['auth', 'verified', 'role:enseignant|super-admin|dg'])
        ->group(function () {

            Route::prefix('notes')->name('notes.')->group(function () {

                Route::get('/', [NoteController::class, 'index'])
                    ->name('index');

                Route::get('/deposer', [NoteController::class, 'create'])
                    ->name('create');

                Route::post('/deposer', [NoteController::class, 'store'])
                    ->name('store');

                Route::get('/{note}/telecharger', [NoteController::class, 'telecharger'])
                    ->name('telecharger');

                Route::delete('/{note}', [NoteController::class, 'destroy'])
                    ->name('destroy');
            });
        });


    // ==================== NOTES (ADMINISTRATION) ====================

    Route::prefix('notes')->name('notes.')->group(function () {

        Route::get('/', [NoteAdminController::class, 'index'])
            ->name('index');

        Route::get('/{note}/telecharger', [NoteAdminController::class, 'telecharger'])
            ->name('telecharger');
    });

    // ==================== SESSIONS DE FORMATION ====================

    Route::resource('sessions-formation', SessionFormationController::class)
        ->except(['show'])
        ->names('sessions-formation');


    // ==================== CATÉGORIES DE FORMATION ====================

    Route::resource('categories-formation', CategorieFormationController::class)
        ->except(['show'])
        ->names('categories-formation');


    // ==================== TYPES DE PIÈCES ====================

    Route::resource('types-pieces', TypePieceController::class)
        ->except(['show'])
        ->names('types-pieces');


    // ==================== PARTENAIRES ====================

    Route::resource('partenaires', PartenaireController::class)
        ->names('partenaires');


    // ==================== CANDIDATURES BACK-OFFICE ====================

    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {

        Route::get('/', [InscriptionAdminController::class, 'index'])
            ->name('index');

        Route::get('/{inscription}', [InscriptionAdminController::class, 'show'])
            ->name('show');

        Route::post(
            '/{inscription}/valider',
            [InscriptionAdminController::class, 'valider']
        )->name('valider');

        Route::post(
            '/{inscription}/rejeter',
            [InscriptionAdminController::class, 'rejeter']
        )->name('rejeter');

        Route::post(
            '/{inscription}/incomplet',
            [InscriptionAdminController::class, 'marquerIncomplet']
        )->name('incomplet');

        Route::post(
            '/pieces/{piece}/verifier',
            [InscriptionAdminController::class, 'verifierPiece']
        )->name('pieces.verifier');
    });

    // ==================== CATEGORIES-DOCUMENTS ====================
    // Route::resource('categories-documents', CategorieDocumentController::class);
    Route::resource(
        'categories-documents',
        CategorieDocumentController::class
    )->parameters([
        'categories-documents' => 'categorie',
    ]);

    // Routes pour les témoignages
    // Rôle USER : ses propres témoignages
    Route::middleware('role:user')->group(function () {
        Route::resource('mes-temoignages', MesTemoignagesController::class)
            ->parameters(['mes-temoignages' => 'temoignage'])
            ->except(['show']);
    });

    // Administration : modération (publier / dépublier / supprimer)
    Route::middleware('backoffice')->group(function () {
        Route::resource('temoignages', TemoignageController::class)->only(['index', 'destroy']);
        Route::patch('temoignages/{temoignage}/toggle', [TemoignageController::class, 'toggle'])
            ->name('temoignages.toggle');
    });


// Personnel : ses propres idées (l'accès est contrôlé par IdeePolicy)
Route::resource('mes-idees', IdeeController::class)
    ->parameters(['mes-idees' => 'idee'])
    ->names('idees')
    ->except(['show']);

// DG / SG : toutes les idées
Route::resource('boite-a-idees', IdeeDirectionController::class)
    ->parameters(['boite-a-idees' => 'idee'])
    ->names('idees-direction')
    ->only(['index', 'show', 'update']);


    // ==================== PHOTOS ====================

    Route::resource('photos', PhotoAdminController::class)
        ->names('photos');

    Route::resource('videos', VideoAdminController::class);



Route::resource(
    'recherches-innovations',
    RechercheInnovationController::class
);

// Publier / dépublier une recherche ou une innovation
Route::patch('recherches-innovations/{recherches_innovation}/publier', [RechercheInnovationController::class, 'publier'])
    ->name('recherches-innovations.publier');

Route::patch('recherches-innovations/{recherches_innovation}/depublier', [RechercheInnovationController::class, 'depublier'])
    ->name('recherches-innovations.depublier');
});
