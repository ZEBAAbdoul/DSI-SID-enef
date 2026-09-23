<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePieceInscriptionRequest;
use App\Models\Inscription;
use App\Models\PieceInscription;
use App\Models\SessionFormation;
use App\Models\TypePiece;
use App\Notifications\InscriptionDeposeeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InscriptionController extends Controller
{
    // public function show(): View
    // {
    //     $inscription = Inscription::with(['pieces', 'formation', 'session'])
    //         ->where('candidat_id', auth()->id())
    //         ->latest()
    //         ->first();

    //     $typesPieces = TypePiece::actifs()->get();

    //     return view('candidat.inscription', compact('inscription', 'typesPieces'));
    // }

    public function show(Inscription $inscription): View
    {
        // Sécurité : le candidat ne peut voir que sa propre candidature
        abort_if(
            $inscription->candidat_id !== auth()->id(),
            403,
            'Vous n’êtes pas autorisé à consulter cette candidature.'
        );

        $inscription->load([
            'pieces',
            'formation.categorie',
            'session',
            'pieces.typePiece',
        ]);

        $typesPieces = TypePiece::actifs()->get();

        return view(
            'candidat.inscription',
            compact('inscription', 'typesPieces')
        );
    }

    // public function create(): View
    // {
    //     $sessions = SessionFormation::with('formation.categorie')
    //         ->where('statut', 'ouverte')
    //         ->where('date_debut', '>=', now())
    //         ->where('places_disponibles', '>', 0)
    //         ->orderBy('date_debut')
    //         ->get();

    //     $typesPieces = TypePiece::actifs()->get();

    //     return view('candidat.choisir-session', compact('sessions', 'typesPieces'));
    // }

    public function create(): View
    {
        $sessions = SessionFormation::with('formation.categorie')
            ->where('statut', 'ouverte')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->get();

        // Récupérer les candidatures du candidat connecté
        $inscriptions = Inscription::where('candidat_id', auth()->id())
            ->whereIn('session_formation_id', $sessions->pluck('id'))
            ->get()
            ->keyBy('session_formation_id');

        $typesPieces = TypePiece::actifs()->get();

        return view(
            'candidat.choisir-session',
            compact('sessions', 'typesPieces', 'inscriptions')
        );
    }


    public function createforme(SessionFormation $session)
    {
        $session->load([
            'formation.categorie'
        ]);

        // Vérifier que la session est ouverte
        if ($session->statut !== 'ouverte') {
            return redirect()
                ->route('admin.inscription.create')
                ->withErrors([
                    'inscription' => 'Cette session de formation n’est plus ouverte.'
                ]);
        }

        // Vérifier les places
        if ($session->places_disponibles <= 0) {
            return redirect()
                ->route('admin.inscription.create')
                ->withErrors([
                    'inscription' => 'Cette session est complète.'
                ]);
        }

        // Vérifier si le candidat est déjà inscrit
        $dejaInscrit = \App\Models\Inscription::where(
            'candidat_id',
            auth()->id()
        )
            ->where(
                'session_formation_id',
                $session->id
            )
            ->exists();

        if ($dejaInscrit) {
            return redirect()
                ->route('admin.inscription.create')
                ->withErrors([
                    'inscription' => 'Vous êtes déjà inscrit à cette session.'
                ]);
        }

        $typesPieces = TypePiece::actifs()->get();

        return view(
            'candidat.inscription-forme',
            compact('session', 'typesPieces')
        );
    }


    public function store(Request $request): RedirectResponse
    {
        $existante = Inscription::where('candidat_id', auth()->id())
            ->enCours()
            ->first();

        if ($existante) {
            return redirect()
                ->route('admin.inscription.show', $existante->id)
                ->with('status', 'Vous avez déjà un dossier de candidature en cours.');
        }

        $typesPieces = TypePiece::actifs()->get();

        $regles = [
            'session_formation_id' => ['required', 'exists:sessions_formation,id'],
            'commentaire' => ['nullable', 'string'],
        ];

        foreach ($typesPieces as $type) {
            $regles["pieces.{$type->code}"] = [
                $type->obligatoire ? 'required' : 'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ];
        }

        $request->validate($regles);

        $inscription = DB::transaction(function () use ($request, $typesPieces) {
            $session = SessionFormation::lockForUpdate()->findOrFail($request->session_formation_id);

            if ($session->places_disponibles < 1) {
                abort(422, 'Cette session n\'a plus de places disponibles.');
            }

            $session->decrement('places_disponibles');

            $inscription = Inscription::create([
                'candidat_id' => auth()->id(),
                'formation_id' => $session->formation_id,
                'session_formation_id' => $session->id,
                'numero_dossier' => Inscription::genererNumeroDossier(),
                'statut' => 'depose',
                'date_soumission' => now(),
            ]);

            foreach ($typesPieces as $type) {
                $fichier = $request->file("pieces.{$type->code}");

                if (! $fichier) {
                    continue;
                }

                $chemin = $fichier->store('inscriptions/' . $inscription->id, 'local');

                PieceInscription::create([
                    'inscription_id' => $inscription->id,
                    'type_piece' => $type->code,
                    'fichier_url' => $chemin,
                    'format_fichier' => $fichier->getClientOriginalExtension(),
                    'taille_fichier_ko' => round($fichier->getSize() / 1024),
                    'statut_verification' => 'en_attente',
                    'resoumis' => false,
                    'verifie_le' => null,
                ]);
            }

            if ($inscription->pieces()->exists()) {
                $inscription->update(['statut' => 'en_cours']);
            }

            return $inscription;
        });

        // Envoie de mail
        $inscription->candidat?->notify(new InscriptionDeposeeNotification($inscription));

        return redirect()
            ->route('admin.inscription.show', $inscription->id)
            ->with(
                'status',
                "Votre candidature a été enregistrée sous le numéro {$inscription->numero_dossier}."
            );
    }

    public function storePiece(StorePieceInscriptionRequest $request, Inscription $inscription): RedirectResponse
    {
        abort_if($inscription->candidat_id !== auth()->id(), 403);

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('inscriptions/' . $inscription->id, 'local');

        PieceInscription::create([
            'inscription_id' => $inscription->id,
            'type_piece' => $request->type_piece,
            'fichier_url' => $chemin,
            'format_fichier' => $fichier->getClientOriginalExtension(),
            'taille_fichier_ko' => round($fichier->getSize() / 1024),
            'statut_verification' => 'en_attente',
        ]);

        if ($inscription->statut === 'depose') {
            $inscription->update(['statut' => 'en_cours']);
        }

        return back()->with('status', 'Pièce déposée avec succès.');
    }

    public function telechargerPiece(PieceInscription $piece): StreamedResponse
    {
        $inscription = $piece->inscription;

        $estProprietaire = $inscription->candidat_id === auth()->id();
        $estPersonnel = auth()->user()?->hasRole(['super-admin', 'admin', 'dg', 'sg', 'se', 'sc']);
        abort_unless($estProprietaire || $estPersonnel, 403);

        abort_unless(Storage::disk('local')->exists($piece->fichier_url), 404);

        return Storage::disk('local')->response($piece->fichier_url);
    }


    public function updatePiece(Request $request, PieceInscription $piece): RedirectResponse
    {
        $inscription = $piece->inscription;

        // Sécurité : seul le propriétaire peut modifier
        abort_if($inscription->candidat_id !== auth()->id(), 403);

        // Interdire la modif si la pièce est déjà conforme ou le dossier validé
        abort_if($piece->estConforme(), 403, 'Cette pièce est déjà validée, vous ne pouvez plus la modifier.');
        abort_if($inscription->statut === 'valide', 403, 'Impossible de modifier un dossier déjà validé.');

        $request->validate([
            'fichier' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        // On sait qu'il y a resoumission si la pièce a déjà été vérifiée au moins une fois
        $etaitDejaVerifiee = $piece->verifie_le !== null;

        // Supprimer l'ancien fichier physique (uniquement s'il existe réellement)
        if ($piece->fichier_url && Storage::disk('local')->exists($piece->fichier_url)) {
            Storage::disk('local')->delete($piece->fichier_url);
        }

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('inscriptions/' . $inscription->id, 'local');

        $piece->update([
            'fichier_url' => $chemin,
            'format_fichier' => $fichier->getClientOriginalExtension(),
            'taille_fichier_ko' => round($fichier->getSize() / 1024),
            'statut_verification' => 'en_attente', // remet en vérification
            'commentaire' => null,
            'resoumis' => $etaitDejaVerifiee,
        ]);

        return back()->with('status', 'Fichier remplacé avec succès, en attente de vérification.');
    }

    public function destroyPiece(PieceInscription $piece): RedirectResponse
    {
        $inscription = $piece->inscription;

        abort_if($inscription->candidat_id !== auth()->id(), 403);
        abort_if($inscription->statut === 'valide', 403, 'Impossible de modifier un dossier déjà validé.');

        Storage::disk('local')->delete($piece->fichier_url);
        $piece->delete();

        return back()->with('status', 'Pièce supprimée.');
    }
}
