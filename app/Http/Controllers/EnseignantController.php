<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Personne;
use App\Models\User;
use App\Notifications\CompteCreeNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EnseignantController extends Controller
{
    private const MOT_DE_PASSE_PAR_DEFAUT = 'enef@enef2026';
    private const ROLE = 'enseignant';

    public function index(Request $request): View
    {
        $query = Enseignant::with('user.personne')
            ->reels();

        if ($request->filled('search')) {
            $query->recherche(trim($request->search));
        }

        if ($request->filled('statut')) {
            $query->byStatut($request->statut);
        }

        $enseignants = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.enseignants.index', compact('enseignants'));
    }

    public function create(): View
    {
        return view('admin.enseignants.create');
    }

// À fusionner dans ton EnseignantController : remplace uniquement la méthode store()
// et ajoute l'import de la notification en haut du fichier :
//     use App\Notifications\CompteCreeNotification;

public function store(Request $request): RedirectResponse
{
    $validated = $request->validate($this->reglesPersonneEtUser() + [
        'specialite' => ['nullable', 'string', 'max:150'],
        'telephone'  => ['nullable', 'string', 'max:20'],
        'statut'     => ['required', 'in:actif,inactif,suspendu'],
    ]);

    $user = DB::transaction(function () use ($validated) {

        $personne = Personne::create([
            'nationalite_type'    => $validated['nationalite_type'],
            'pays_nationalite'    => $validated['pays_nationalite'] ?? null,
            'nom'                 => $validated['nom'],
            'prenom'              => $validated['prenom'],
            'sexe'                => $validated['sexe'],
            'date_naissance'      => $validated['date_naissance'],
            'lieu_naissance'      => $validated['lieu_naissance'],
            'piece_type'          => $validated['piece_type'],
            'piece_numero'        => $validated['piece_numero'],
            'telephone_indicatif' => $validated['telephone_indicatif'] ?? '+226',
            'telephone'           => $validated['telephone_personne'],
            'adresse'             => $validated['adresse'] ?? null,
            'ville'               => $validated['ville'] ?? null,
            'pays_residence'      => $validated['pays_residence'] ?? 'Burkina Faso',
        ]);

        $user = User::create([
            'personne_id' => $personne->id,
            'email'       => $validated['email'],
            'password'    => Hash::make(self::MOT_DE_PASSE_PAR_DEFAUT),
            // Compte créé par un administrateur : adresse considérée comme vérifiée
            // (sinon le middleware "verified" bloquerait l'accès sans qu'aucun e-mail ne soit envoyé)
            'email_verified_at' => now(),
        ]);

        $user->assignRole(self::ROLE);

        Enseignant::create([
            'user_id'    => $user->id,
            'specialite' => $validated['specialite'] ?? null,
            'telephone'  => $validated['telephone'] ?? $validated['telephone_personne'],
            'statut'     => $validated['statut'],
        ]);

        return $user;
    });

    // Envoi des identifiants, une fois le compte enregistré (en dehors de la transaction :
    // un e-mail qui échoue ne doit pas annuler la création du compte).
    try {
        $user->notify(new CompteCreeNotification(self::MOT_DE_PASSE_PAR_DEFAUT));
    } catch (\Throwable $e) {
        report($e);

        return redirect()
            ->route('admin.enseignants.index')
            ->with(
                'warning',
                "Enseignant créé, mais l'e-mail n'a pas pu être envoyé à {$user->email}. "
                . 'Mot de passe par défaut à lui transmettre : ' . self::MOT_DE_PASSE_PAR_DEFAUT
            );
    }

    return redirect()
        ->route('admin.enseignants.index')
        ->with('success', "L'enseignant a été créé. Ses identifiants ont été envoyés à {$user->email}.");
}

    public function edit(Enseignant $enseignant): View
    {
        $enseignant->load('user.personne');

        return view(
            'admin.enseignants.edit',
            compact('enseignant')
        );
    }

    public function update(Request $request, Enseignant $enseignant): RedirectResponse
    {
        $enseignant->loadMissing('user.personne');

        $validated = $request->validate($this->reglesPersonneEtUser($enseignant) + [
            'specialite' => ['nullable', 'string', 'max:150'],
            'telephone'  => ['nullable', 'string', 'max:20'],
            'statut'     => ['required', 'in:actif,inactif,suspendu'],
        ]);

        DB::transaction(function () use ($validated, $enseignant) {

            $enseignant->personne->update([
                'nationalite_type'    => $validated['nationalite_type'],
                'pays_nationalite'    => $validated['pays_nationalite'] ?? null,
                'nom'                 => $validated['nom'],
                'prenom'              => $validated['prenom'],
                'sexe'                => $validated['sexe'],
                'date_naissance'      => $validated['date_naissance'],
                'lieu_naissance'      => $validated['lieu_naissance'],
                'piece_type'          => $validated['piece_type'],
                'piece_numero'        => $validated['piece_numero'],
                'telephone_indicatif' => $validated['telephone_indicatif'] ?? '+226',
                'telephone'           => $validated['telephone_personne'],
                'adresse'             => $validated['adresse'] ?? null,
                'ville'               => $validated['ville'] ?? null,
                'pays_residence'      => $validated['pays_residence'] ?? 'Burkina Faso',
            ]);

            $enseignant->user->update([
                'email' => $validated['email'],
            ]);

            // S'assurer que le rôle reste "enseignant" même si le compte
            // a été modifié entre-temps par une autre partie de l'admin.
            if (! $enseignant->user->hasRole(self::ROLE)) {
                $enseignant->user->syncRoles([self::ROLE]);
            }

            $enseignant->update([
                'specialite' => $validated['specialite'] ?? null,
                'telephone'  => $validated['telephone'] ?? $validated['telephone_personne'],
                'statut'     => $validated['statut'],
            ]);
        });

        return redirect()
            ->route('admin.enseignants.index')
            ->with('success', 'L\'enseignant a été mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant): RedirectResponse
    {
        $enseignant->loadMissing('user.personne');
        $nom = $enseignant->nom_complet;

        DB::transaction(function () use ($enseignant) {
            $user = $enseignant->user;
            $personne = $enseignant->personne;

            $enseignant->delete();
            $user?->delete();
            $personne?->delete();
        });

        return redirect()
            ->route('admin.enseignants.index')
            ->with('success', "L'enseignant « {$nom} » a été supprimé avec succès.");
    }

    private function reglesPersonneEtUser(?Enseignant $enseignant = null): array
    {
        $personneId = $enseignant?->personne?->id;
        $userId     = $enseignant?->user?->id;

        return [
            'nationalite_type'    => ['required', 'in:nationale,internationale'],
            'pays_nationalite'    => ['nullable', 'string', 'max:100'],
            'nom'                 => ['required', 'string', 'max:255'],
            'prenom'              => ['required', 'string', 'max:255'],
            'sexe'                => ['required', 'in:M,F'],
            'date_naissance'      => ['required', 'date', 'before:today'],
            'lieu_naissance'      => ['required', 'string', 'max:255'],
            'piece_type'          => ['required', 'in:cnib,passeport'],
            'piece_numero'        => [
                'required',
                'string',
                'max:50',
                'unique:personnes,piece_numero' . ($personneId ? ",{$personneId}" : ''),
            ],
            'telephone_indicatif' => ['nullable', 'string', 'max:6'],
            'telephone_personne'  => ['required', 'string', 'max:20'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'ville'               => ['nullable', 'string', 'max:100'],
            'pays_residence'      => ['nullable', 'string', 'max:100'],
            'email'               => [
                'required',
                'email',
                'max:255',
                'unique:users,email' . ($userId ? ",{$userId}" : ''),
            ],
        ];
    }
}
