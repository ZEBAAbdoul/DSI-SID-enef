<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Document;
use App\Models\Formation;
use App\Models\Information;
use App\Models\Inscription;
use App\Models\SessionFormation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Dashboard : chaque utilisateur voit le sien selon son rôle.
     * Pour ajouter un rôle, ajoute une ligne : 'role' => 'méthode'.
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        $dashboards = [
            'enseignant' => 'tableauEnseignant',
            'user'       => 'tableauCandidat',
        ];

        foreach ($dashboards as $role => $methode) {
            if ($user->hasRole($role)) {
                return $this->{$methode}($user);
            }
        }

        // Rôle sans dashboard dédié (admin) : statistiques globales
        return $this->tableauAdmin();
    }

    /* ------------------------------------------------------------------ */
    /*  Dashboards par rôle                                                */
    /* ------------------------------------------------------------------ */

    private function tableauAdmin(): View
    {
        $stats = [
            'candidatures_total'  => Inscription::count(), // à remplacer par Candidature::count() si cette table existe
            'formations_ouvertes' => Formation::ouvertes()->count(),
            'sessions_a_venir'    => SessionFormation::ouvertes()
                ->where('date_debut', '>=', now())
                ->count(),
            'places_disponibles'  => SessionFormation::ouvertes()
                ->where('date_debut', '>=', now())
                ->sum('places_disponibles'),
            'documents_publies'   => Document::count(),
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

    private function tableauCandidat($user): View
    {
        $inscriptions = Inscription::where('candidat_id', $user->id)->latest()->get();
        $idsSessions  = $inscriptions->pluck('session_formation_id');

        // Sessions du candidat, indexées par id (évite de dépendre du nom de la relation)
        $sessionsCandidat = SessionFormation::with('formation')
            ->whereIn('id', $idsSessions)
            ->get()
            ->keyBy('id');

        // Sessions où il peut encore candidater
        $sessionsOuvertes = SessionFormation::with('formation')
            ->where('statut', 'ouverte')
            ->whereDate('date_debut', '>=', today())
            ->where(fn($q) => $q->whereNull('date_limite_depot')
                ->orWhereDate('date_limite_depot', '>=', today()))
            ->whereNotIn('id', $idsSessions)
            ->orderBy('date_limite_depot')
            ->orderBy('date_debut')
            ->limit(5)
            ->get();

        $informations = $this->informationsPour($user);

        return view('dashboard.candidat', compact(
            'inscriptions',
            'sessionsCandidat',
            'sessionsOuvertes',
            'informations'
        ));
    }

    private function tableauEnseignant($user): View
    {
        $informations = $this->informationsPour($user);

        return view('dashboard.enseignant', compact('informations'));
    }

    private function informationsPour($user)
    {
        return Information::pourUtilisateur($user)
            ->orderByDesc('publie_le')
            ->limit(5)
            ->get();
    }

    /* ------------------------------------------------------------------ */
    /*  Graphique                                                          */
    /* ------------------------------------------------------------------ */

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

    /* ------------------------------------------------------------------ */
    /*  Profil                                                             */
    /* ------------------------------------------------------------------ */

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
        $user->save();

        return Redirect::route('admin.profile.edit')->with('success', 'Profil mis à jour avec succès');
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
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(12)],
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
