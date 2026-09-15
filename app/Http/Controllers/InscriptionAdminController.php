<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\PieceInscription;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InscriptionAdminController extends Controller
{
    public function index(Request $request): View
    {
        $inscriptions = Inscription::with(['candidat', 'formation', 'session'])
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->statut))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function show(Inscription $inscription): View
    {
        $inscription->load(['candidat', 'formation', 'session', 'pieces']);

        return view('admin.inscriptions.show', compact('inscription'));
    }

    public function valider(Inscription $inscription): RedirectResponse
{
    $toutesConformes = $inscription->pieces->isNotEmpty()
        && $inscription->pieces->every(fn ($piece) => $piece->statut_verification === 'conforme');

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
        ]);

        return back()->with('status', 'Statut de la pièce mis à jour.');
    }
}