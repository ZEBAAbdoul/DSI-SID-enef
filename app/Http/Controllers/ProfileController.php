<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Document;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\SessionFormation;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'candidatures_total' => Inscription::count(), // à remplacer par Candidature::count() si cette table existe
            'formations_ouvertes' => Formation::ouvertes()->count(),
            'sessions_a_venir' => SessionFormation::ouvertes()
                ->where('date_debut', '>=', now())
                ->count(),
            'places_disponibles' => SessionFormation::ouvertes()
                ->where('date_debut', '>=', now())
                ->sum('places_disponibles'),
            'documents_publies' => Document::count(),
        ];

        $prochainesSessions = SessionFormation::with('formation')
            ->where('statut', 'ouverte')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->take(10)
            ->get();

        $formationsPopulaires = Formation::withCount('sessions')
            ->orderByDesc('sessions_count')
            ->take(5)
            ->get();

        $inscriptionsParMois = $this->getMonthlyInscriptionsData();

        return view('dashboard', compact(
            'stats',
            'prochainesSessions',
            'formationsPopulaires',
            'inscriptionsParMois'
        ));
    }

    public function getChartData()
    {
        return response()->json($this->getMonthlyInscriptionsData());
    }

    private function getMonthlyInscriptionsData(): array
    {
        // 6 mois calendaires : le mois courant + les 5 précédents
        $debut = now()->startOfMonth()->subMonths(5);

        $comptes = Inscription::query()
            ->whereRaw('COALESCE(date_soumission, created_at) >= ?', [$debut])
            ->selectRaw("TO_CHAR(COALESCE(date_soumission, created_at), 'YYYY-MM') as mois, COUNT(*) as total")
            ->groupBy('mois')
            ->pluck('total', 'mois');

        $labels = [];
        $values = [];

        // Les mois sans inscription apparaissent avec la valeur 0
        for ($i = 0; $i < 6; $i++) {
            $mois = $debut->copy()->addMonths($i);

            $labels[] = ucfirst($mois->translatedFormat('M Y'));
            $values[] = (int) $comptes->get($mois->format('Y-m'), 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.partials.update-profile-information-form', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Nom / prénom vivent sur la Personne rattachée, pas sur le User
        $user->personne->update([
            'nom'    => $validated['nom'],
            'prenom' => $validated['prenom'],
        ]);

        if ($user->email !== $validated['email']) {
            $user->email_verified_at = null;
        }

        $user->email = $validated['email'];
        // $user->mode  = $validated['mode'];
        $user->save();

        return Redirect::route('admin.profile.edit')->with('success', 'profil mis à jour avec succès');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


// ...

    /**
     * Display the user's password edit form.
     */
    public function editPassword(Request $request): View
    {
        return view('profile.partials.update-password-form', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's password.
     */

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'          => ['required', 'confirmed', Password::min(12)],
        ]);

        // Interdit de reprendre le même mot de passe
        if (Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => 'Le nouveau mot de passe doit être différent de l\'actuel.',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('admin.profile.password.edit')->with('success', 'Mot de passe mis à jour avec succès');
    }
}
