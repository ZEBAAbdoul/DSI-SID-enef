<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\PieceInscription;
use App\Models\SessionFormation;
use App\Notifications\InscriptionIncompleteNotification;
use App\Notifications\InscriptionRejeteeNotification;
use App\Notifications\InscriptionValideeNotification;
use App\Notifications\PieceVerifieeNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InscriptionAdminController extends Controller
{
    public function index(Request $request): View
{
    $request->validate([
        'q'          => ['nullable', 'string', 'max:100'],
        'session_id' => ['nullable', 'string'],
        'statut'     => ['nullable', 'in:depose,en_cours,incomplet,valide,rejete'],
        'du'         => ['nullable', 'date'],
        'au'         => ['nullable', 'date', 'after_or_equal:du'],
    ]);

    $recherche = trim((string) $request->input('q'));

    $inscriptions = Inscription::with(['candidat.personne', 'formation', 'session'])
        ->when($recherche !== '', function ($query) use ($recherche) {
            // on échappe % et _ pour qu'ils soient cherchés littéralement
            $like = '%' . addcslashes($recherche, '%_\\') . '%';

            $query->where(function ($q) use ($like) {
                $q->where('numero_dossier', 'ilike', $like)
                  ->orWhereHas('candidat', fn ($c) => $c
                      ->where('email', 'ilike', $like)
                      ->orWhereHas('personne', fn ($p) => $p
                          ->where('nom', 'ilike', $like)
                          ->orWhere('prenom', 'ilike', $like)
                          ->orWhere('telephone', 'ilike', $like)));
            });
        })
        ->when($request->filled('session_id'), fn ($q) => $q->where('session_formation_id', $request->session_id))
        ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->statut))
        ->when($request->filled('du'), fn ($q) => $q->whereDate('date_soumission', '>=', $request->du))
        ->when($request->filled('au'), fn ($q) => $q->whereDate('date_soumission', '<=', $request->au))
        ->latest('date_soumission')
        ->paginate(20)
        ->withQueryString();

    $sessions = SessionFormation::with('formation:id,titre')
        ->orderByDesc('date_debut')
        ->get();

    // Compteurs pour les pastilles de statut
    $comptes = Inscription::selectRaw('statut, count(*) as total')
        ->groupBy('statut')
        ->pluck('total', 'statut');

    return view('admin.inscriptions.index', compact('inscriptions', 'sessions', 'comptes'));
}

    public function show(Inscription $inscription): View
    {
        $inscription->load([
            'candidat.personne',
            'formation.categorie',
            'session',
            'pieces',
            'traitePar.personne',
        ]);
        return view('admin.inscriptions.show', compact('inscription'));
    }

    public function valider(Inscription $inscription): RedirectResponse
    {
        $toutesConformes = $inscription->pieces->isNotEmpty()
            && $inscription->pieces->every(fn($piece) => $piece->statut_verification === 'conforme');

        abort_unless(
            $toutesConformes,
            403,
            'Toutes les pièces doivent être conformes avant de valider ce dossier.'
        );

        $inscription->update([
            'statut' => 'valide',
            'date_traitement' => now(),
            'traite_par' => auth()->id(),
            'motif_rejet' => null,
        ]);

        $inscription->candidat?->notify(new InscriptionValideeNotification($inscription));

        return back()->with('status', 'Dossier validé.');
    }

    public function rejeter(Request $request, Inscription $inscription): RedirectResponse
    {
        $request->validate([
            'motif_rejet' => ['required', 'string', 'max:500'],
        ]);

        $inscription->update([
            'statut' => 'rejete',
            'date_traitement' => now(),
            'traite_par' => auth()->id(),
            'motif_rejet' => $request->motif_rejet,
        ]);

        // Libère la place réservée sur la session
        if ($inscription->session) {
            $inscription->session->increment('places_disponibles');
        }

        $inscription->candidat?->notify(new InscriptionRejeteeNotification($inscription));

        return back()->with('status', 'Dossier rejeté et place libérée.');
    }

    public function marquerIncomplet(Request $request, Inscription $inscription): RedirectResponse
    {
        $request->validate([
            'motif_rejet' => ['required', 'string', 'max:500'],
        ]);

        $inscription->update([
            'statut' => 'incomplet',
            'date_traitement' => now(),
            'traite_par' => auth()->id(),
            'motif_rejet' => $request->motif_rejet,
        ]);

        $inscription->candidat?->notify(new InscriptionIncompleteNotification($inscription));

        return back()->with('status', 'Dossier marqué incomplet.');
    }

    public function verifierPiece(Request $request, PieceInscription $piece): RedirectResponse
    {
        $request->validate([
            'statut_verification' => ['required', 'in:conforme,non_conforme'],
            'commentaire' => ['nullable', 'string', 'max:500'],
        ]);

        $piece->update([
            'statut_verification' => $request->statut_verification,
            'commentaire' => $request->commentaire,
            'resoumis' => false,
            'verifie_le' => now(),
        ]);

        $piece->inscription?->candidat?->notify(new PieceVerifieeNotification($piece));

        return back()->with('status', 'Statut de la pièce mis à jour.');
    }
}
