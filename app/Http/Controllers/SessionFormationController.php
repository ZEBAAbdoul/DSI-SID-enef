<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\SessionFormation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessionFormationController extends Controller
{
    public function index(Request $request): View
    {
        $sessions = SessionFormation::with('formation')
            ->when($request->filled('statut'), fn($q) => $q->where('statut', $request->statut))
            ->orderByDesc('date_debut')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sessions-formation.index', compact('sessions'));
    }

    public function create(): View
    {
        $formations = Formation::orderBy('titre')->get();

        return view('admin.sessions-formation.create', compact('formations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSession($request);

        SessionFormation::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.sessions-formation.index')
            ->with('status', 'Session créée avec succès.');
    }

    public function edit(SessionFormation $sessionsFormation): View
    {
        $formations = Formation::orderBy('titre')->get();

        return view('admin.sessions-formation.edit', [
            'session' => $sessionsFormation,
            'formations' => $formations,
        ]);
    }

    public function update(Request $request, SessionFormation $sessionsFormation): RedirectResponse
    {
        $validated = $this->validateSession($request, $sessionsFormation->id);

        $sessionsFormation->update($validated);

        return redirect()
            ->route('admin.sessions-formation.index')
            ->with('status', 'Session mise à jour avec succès.');
    }

    public function destroy(SessionFormation $sessionsFormation): RedirectResponse
    {
        $sessionsFormation->delete();

        return redirect()
            ->route('admin.sessions-formation.index')
            ->with('status', 'Session supprimée.');
    }

    private function validateSession(Request $request, ?string $ignoreId = null): array
    {
        return $request->validate([
            'formation_id' => ['required', 'exists:formations,id'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'lieu' => ['nullable', 'string', 'max:255'],
            'places_totales' => ['required', 'integer', 'min:1'],
            'places_disponibles' => ['required', 'integer', 'min:0', 'lte:places_totales'],
            'statut' => ['required', 'in:ouverte,complete,cloturee'],
        ]);
    }
}
