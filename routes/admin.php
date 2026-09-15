<?php

use App\Http\Controllers\CategorieDocumentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InscriptionAdminController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ParametresSiteController;
use App\Http\Controllers\CategorieFormationController;
use App\Http\Controllers\SessionFormationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/chart-data', [ProfileController::class, 'getChartData'])->name('dashboard.chart-data');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Un seul jeu de routes utilisateurs (pluriel, convention REST standard)
    Route::resource('users', UserController::class)->names('user');
    Route::get('/users/stats', [UserController::class, 'stats'])->name('user.stats');

    Route::middleware(['role:Gérant'])->group(function () {
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
    });

    // ==================== BIBLIOTHÈQUE DOCUMENTAIRE (back-office) ====================
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('update');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categories-documents')->name('categories-documents.')->group(function () {
        Route::get('/', [CategorieDocumentController::class, 'index'])->name('index');
        Route::post('/', [CategorieDocumentController::class, 'store'])->name('store');
        Route::get('/{categorie}', [CategorieDocumentController::class, 'show'])->name('show');
        Route::put('/{categorie}', [CategorieDocumentController::class, 'update'])->name('update');
        Route::delete('/{categorie}', [CategorieDocumentController::class, 'destroy'])->name('destroy');
    });

    // ==================== PARAMÈTRES DU SITE ====================
    Route::get('parametres/public', [ParametresSiteController::class, 'getPublicSettings'])
        ->name('parametres.public');

    Route::prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/', [ParametresSiteController::class, 'index'])->name('index');
        Route::get('/{parametre}', [ParametresSiteController::class, 'show'])->name('show');
        Route::post('/', [ParametresSiteController::class, 'store'])->name('store');
        Route::put('/{parametre}', [ParametresSiteController::class, 'update'])->name('update');
        Route::delete('/{parametre}', [ParametresSiteController::class, 'destroy'])->name('destroy');
    });

    // Inscription routes for admin candidat
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

        // Supprimer une pièce
        Route::delete(
            'pieces/{piece}',
            [InscriptionController::class, 'destroyPiece']
        )->name('piece.destroy');
    });

    // ==================== SESSIONS DE FORMATION (back-office) ====================
    Route::resource('sessions-formation', SessionFormationController::class)
        ->except(['show'])
        ->names('sessions-formation');

    // ==================== CATÉGORIES DE FORMATION (back-office) ====================
    Route::resource('categories-formation', CategorieFormationController::class)
        ->except(['show'])
        ->names('categories-formation');

    // ==================== CANDIDATURES (back-office) ====================
    Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
        Route::get('/', [InscriptionAdminController::class, 'index'])->name('index');
        Route::get('/{inscription}', [InscriptionAdminController::class, 'show'])->name('show');
        Route::post('/{inscription}/valider', [InscriptionAdminController::class, 'valider'])->name('valider');
        Route::post('/{inscription}/rejeter', [InscriptionAdminController::class, 'rejeter'])->name('rejeter');
        Route::post('/{inscription}/incomplet', [InscriptionAdminController::class, 'marquerIncomplet'])->name('incomplet');
        Route::post('/pieces/{piece}/verifier', [InscriptionAdminController::class, 'verifierPiece'])->name('pieces.verifier');
    });
});
