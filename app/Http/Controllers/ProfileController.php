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

class ProfileController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'candidatures_total' => User::count(), // à remplacer par Candidature::count() si cette table existe
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
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        User::where('id', $request->user()->id)->update(['mode' => $request->mode]);

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
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
}
