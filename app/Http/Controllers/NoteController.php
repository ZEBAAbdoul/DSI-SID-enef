<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\SessionFormation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $enseignant = auth()->user()->enseignant;

        // Toutes les sessions de formation
        $sessions = SessionFormation::with('formation')
            ->orderByDesc('date_debut')
            ->get();

        // Notes déposées par l'enseignant connecté
        $notes = Note::with([
            'formation',
            'session',
            'matiere'
        ])
            ->where('enseignant_id', $enseignant->id)

            ->when(
                $request->filled('matiere_id'),
                fn($q) => $q->where(
                    'matiere_id',
                    $request->matiere_id
                )
            )

            ->when(
                $request->filled('type_evaluation'),
                fn($q) => $q->where(
                    'type_evaluation',
                    $request->type_evaluation
                )
            )

            ->when(
                $request->filled('date_evaluation'),
                fn($q) => $q->whereDate(
                    'date_evaluation',
                    $request->date_evaluation
                )
            )

            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $matieres = Matiere::orderBy('nom')->get();

        return view(
            'admin.enseignants.notes.index',
            compact(
                'notes',
                'matieres',
                'sessions'
            )
        );
    }

    public function create()
{
    $formations = Formation::whereHas('categorie', function ($q) {
            $q->where('slug', 'formation-initiale');
        })
        ->orderBy('titre')
        ->get();

    $matieres = Matiere::orderBy('nom')->get();

    $sessions = SessionFormation::with('formation')
        ->whereHas('formation.categorie', function ($q) {
            $q->where('slug', 'formation-initiale');
        })
        ->orderByDesc('date_debut')
        ->get();

    return view('admin.enseignants.notes.create', compact('formations', 'matieres', 'sessions'));
}

    public function store(Request $request)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'session_formation_id' => 'nullable|exists:sessions_formation,id',
            'matiere_id' => 'required|exists:matieres,id',
            'type_evaluation' => 'required|in:controle,examen,tp,oral,projet',
            'date_evaluation' => 'nullable|date',
            'commentaire' => 'nullable|string',
            'annee' => 'nullable|string',
            'fichier' => 'required|file|mimes:xlsx,xls,csv,pdf|max:10240',
        ]);

        $file = $request->file('fichier');
        $chemin = $file->store('notes', 'public');

        Note::create([
            'enseignant_id' => auth()->user()->enseignant->id,
            'formation_id' => $request->formation_id,
            'session_formation_id' => $request->session_formation_id,
            'matiere_id' => $request->matiere_id,
            'type_evaluation' => $request->type_evaluation,
            'fichier' => $chemin,
            'nom_original' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'taille' => $file->getSize(),
            'commentaire' => $request->commentaire,
            'annee' => $request->annee,
            'date_evaluation' => $request->date_evaluation,
        ]);

        return redirect()->route('admin.enseignant.notes.index')
            ->with('success', 'Fichier de notes envoyé avec succès.');
    }

    public function telecharger(Note $note)
    {
        abort_unless($note->enseignant_id === auth()->user()->enseignant->id, 403);

        return Storage::disk('public')->download($note->fichier, $note->nom_original);
    }

    public function destroy(Note $note)
    {
        abort_unless($note->enseignant_id === auth()->user()->enseignant->id, 403);

        Storage::disk('public')->delete($note->fichier);
        $note->delete();

        return back()->with('success', 'Fichier supprimé.');
    }
}
