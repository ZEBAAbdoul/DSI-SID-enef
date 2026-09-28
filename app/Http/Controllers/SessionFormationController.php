<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\SessionFormation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SessionFormationController extends Controller
{
    public function index(Request $request): View
    {
        $sessions = SessionFormation::with('formation')
            ->when($request->filled('statut'), fn($q) => $q->where('statut', $request->statut))
            ->orderByDesc('date_debut')
            ->paginate(10)
            ->withQueryString();

        return view('admin.sessions-formation.index', compact('sessions'));
    }

    public function create(): View
    {
        $formations = Formation::whereHas('categorie', function ($q) {
            $q->where('slug', 'formation-initiale');
        })
            ->orderBy('titre')
            ->get();

        return view('admin.sessions-formation.create', compact('formations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'formation_ids'   => ['required', 'array', 'min:1'],
            'formation_ids.*' => ['distinct', 'uuid', 'exists:formations,id'],
        ]);

        // formation_id temporaire pour réutiliser validateSession tel quel
        $request->merge(['formation_id' => $request->input('formation_ids')[0]]);
        $validated = $this->validateSession($request);
        unset($validated['formation_id']);

        $formationIds = array_values(array_unique($request->input('formation_ids')));

        // Refus si une des formations a déjà une session sur la période
        $conflits = array_filter(
            $formationIds,
            fn($id) => $this->chevauche($id, $validated['date_debut'], $validated['date_fin'] ?? null)
        );

        if ($conflits) {
            $titres = Formation::whereIn('id', $conflits)->pluck('titre')->implode(', ');

            throw ValidationException::withMessages([
                'formation_ids' => "Une session existe déjà sur cette période pour : {$titres}.",
            ]);
        }

        DB::transaction(function () use ($formationIds, $validated) {
            foreach ($formationIds as $formationId) {
                SessionFormation::create([
                    ...$validated,
                    'formation_id' => $formationId,
                    'created_by'   => auth()->id(),
                ]);
            }
        });

        $count = count($formationIds);

        return redirect()
            ->route('admin.sessions-formation.index')
            ->with('status', $count > 1
                ? "{$count} sessions créées avec succès."
                : 'Session créée avec succès.');
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

        if ($this->chevauche(
            $validated['formation_id'],
            $validated['date_debut'],
            $validated['date_fin'] ?? null,
            $sessionsFormation->id
        )) {
            throw ValidationException::withMessages([
                'formation_id' => 'Une session existe déjà sur cette période pour cette formation.',
            ]);
        }

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

    private function chevauche(string $formationId, string $debut, ?string $fin, ?string $ignoreId = null): bool
    {
        $fin = $fin ?: $debut;

        return SessionFormation::where('formation_id', $formationId)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->whereDate('date_debut', '<=', $fin)
            ->whereRaw('COALESCE(date_fin, date_debut) >= ?', [$debut])
            ->exists();
    }

    private function validateSession(Request $request, ?string $ignoreId = null): array
{
    return $request->validate([
        'formation_id'       => ['required', 'uuid', 'exists:formations,id'],
        'date_debut'         => ['required', 'date'],
        'date_fin'           => ['nullable', 'date', 'after_or_equal:date_debut'],
        'date_limite_depot'  => ['nullable', 'date', 'before_or_equal:date_debut'],
        'lieu'               => ['nullable', 'string', 'max:255'],
        'places_totales'     => ['required', 'integer', 'min:1'],
        'places_disponibles' => ['required', 'integer', 'min:0', 'lte:places_totales'],
        'statut'             => ['required', 'in:ouverte,complete,cloturee'],
    ]);
}
}