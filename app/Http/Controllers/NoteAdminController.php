<?php

namespace App\Http\Controllers;

use App\Imports\NotesImport;
use App\Models\Formation;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\SessionFormation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class NoteAdminController extends Controller
{
    public function index()
{
    $notes = auth()->user()->hasRole('enseignant')
        ? Note::with(['formation', 'session', 'matiere'])
            ->where('enseignant_id', auth()->user()->enseignant->id)
            ->latest()->get()
        : Note::with(['enseignant.user', 'formation', 'session', 'matiere'])
            ->latest()->get();

    return view('admin.enseignants.notes.index', compact('notes'));
}

    public function telecharger(Note $note)
    {
        return Storage::disk('public')->download($note->fichier, $note->nom_original);
    }
}