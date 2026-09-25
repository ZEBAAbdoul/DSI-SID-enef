<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ActualitePublicController;
use App\Http\Controllers\BibliothequeController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationsComplementairesController;
use App\Http\Controllers\LoginWithOTPController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\RechercheInnovationPublicController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use App\Models\ParametresSite;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PhotoPublicController;
use App\Http\Controllers\VideoPublicController;


/*
|---------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/mentions_legale', [HomeController::class, 'mentionLegale'])->name('mentionLegale');
Route::get('/conditionutilisation', [HomeController::class, 'conditionutilisation'])->name('conditionutilisation');
Route::get('/politiqueConfidentialite', [HomeController::class, 'politiqueConfidentialite'])->name('politiqueConfidentialite');

Route::get('/enef', function () {
    return view('auth.login');
});

// Login with OTP Routes
Route::prefix('/otp')->middleware('guest')->name('otp.')->controller(LoginWithOTPController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/generate', 'generate')->name('generate');
    Route::get('/verification/{userId}', 'verification')->name('verification');
    Route::post('login/verification', 'loginWithOtp')->name('loginWithOtp');
});

// Socialite Routes
Route::prefix('oauth/')->group(function () {
    Route::prefix('/github/login')->name('github.')->group(function () {
        Route::get('/', [SocialiteController::class, 'redirectToGithub'])->name('login');
        Route::get('/callback', [SocialiteController::class, 'HandleGithubCallBack'])->name('callback');
    });

    Route::prefix('/google/login')->name('google.')->group(function () {
        Route::get('/', [SocialiteController::class, 'redirectToGoogle'])->name('login');
        Route::get('/callback', [SocialiteController::class, 'HandleGoogleCallBack'])->name('callback');
    });

    Route::prefix('/facebook/login')->name('facebook.')->group(function () {
        Route::get('/', [SocialiteController::class, 'redirectToFaceBook'])->name('login');
        Route::get('/callback', [SocialiteController::class, 'HandleFaceBookCallBack'])->name('callback');
    });
});

// Route pour la documentation
Route::get('/manual', [ManualController::class, 'index'])->name('manual.index');


Route::get('/formations/informations-complementaires', [InformationsComplementairesController::class, 'index'])
    ->name('formations.informations');

Route::get('/formations/{formation:slug}', function (\App\Models\Formation $formation) {
    $formation->load(['filiere', 'categorie']);
    $param_site = ParametresSite::first();

    return view('formations.show', compact('formation', 'param_site'));
})->name('formations.show');



Route::get('/catalogue-formations-initiales', [CatalogueController::class, 'index'])
    ->name('catalogue.formations.initiales');

Route::get('/catalogue-formations-continues', [CatalogueController::class, 'formationContinue'])
    ->name('catalogue.formations.continue');


Route::get('/toutes-les-actualites', [ActualitePublicController::class, 'index'])
    ->name('actualites.index');

Route::get('/actualites/{actualite:slug}', [ActualitePublicController::class, 'show'])
    ->name('actualites.show');

Route::get('/recherches-innovations', [RechercheInnovationPublicController::class, 'index'])
    ->name('recherches-innovations.index');

Route::get('/recherches-innovations/{recherches_innovation:slug}', [RechercheInnovationPublicController::class, 'show'])
    ->name('recherches-innovations.show');


Route::get('/mot-du-directeur', [HomeController::class, 'motDuDirecteur'])->name('mot-directeur');

// Page de contact publique (formulaire + hCaptcha)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Route for the pedagogical units
Route::get('/unites-pedagogiques', [HomeController::class, 'unitesPedagogiques'])->name('unites-pedagogiques');




// Routes d'inscription pour les candidats
// Route::middleware(['auth'])->group(function () {
//     Route::get('/inscription', [InscriptionController::class, 'show'])->name('inscription.show');
//     Route::get('/inscription/choisir-session', [InscriptionController::class, 'create'])->name('inscription.create');
//     Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

//     Route::post('/inscriptions/{inscription}/pieces', [InscriptionController::class, 'storePiece'])->name('inscription.pieces.store');
//     Route::get('/pieces/{piece}/telecharger', [InscriptionController::class, 'telechargerPiece'])->name('pieces.telecharger');
//     Route::delete('/pieces/{piece}', [InscriptionController::class, 'destroyPiece'])->name('pieces.destroy');
// });

// Route pour création de compte candidat
Route::get('/inscription', [UserController::class, 'inscription'])->name('inscription');
Route::post('inscription', [UserController::class, 'storeInscription'])->name('storeInscription');

// Route publique pour bibliothèque de documents
Route::get('/bibliotheque', [BibliothequeController::class, 'telechargeables'])->name('bibliotheque.index');

// Bibliothèque publique — documents en consultation sur place
Route::get('/bibliotheque/consultation', [BibliothequeController::class, 'consultation'])
    ->name('bibliotheque.consultation');

// Téléchargement public d'un document (vérifie en interne qu'il est bien "telechargeable")
Route::get('/bibliotheque/{document}/telecharger', [DocumentController::class, 'telecharger'])
    ->name('documents.telecharger');


// Routes pour la galerie photos

// À coller dans routes/web.php, en dehors du groupe admin
Route::get('/galerie', [PhotoPublicController::class, 'index'])->name('galerie.index');

// Galerie vidéo publique
Route::get('/videos', [VideoPublicController::class, 'index'])->name('videos.index');

// Auth routes
require __DIR__ . '/auth.php';
// Admin Routes
require __DIR__ . '/admin.php';
