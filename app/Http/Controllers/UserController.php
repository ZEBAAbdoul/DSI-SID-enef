<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use App\Notifications\CompteCreeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * Rôles qu'on ne peut PAS attribuer depuis la gestion des utilisateurs (noms en minuscules).
     * - enseignant : créés depuis le module « Enseignants »
     * - user       : rôle des candidats, attribué automatiquement à l'inscription
     */
    private const ROLES_NON_ATTRIBUABLES = ['enseignant', 'user'];

    /** Mot de passe attribué lors d'une réinitialisation par un administrateur. */
    private const MOT_DE_PASSE_PAR_DEFAUT = 'enef@enef2026';


    /** Rôles proposés dans les formulaires de création / modification. */
    private function rolesAttribuables()
    {
        return Role::query()
            ->whereNotIn(DB::raw('LOWER(name)'), array_merge(self::ROLES_NON_ATTRIBUABLES, User::ROLES_MASQUES))
            ->orderBy('name')
            ->get();
    }

    /**
     * Les comptes masqués (super-admin) n'apparaissent pas dans la liste : on bloque aussi l'accès
     * direct par URL (édition, suppression…) pour quiconque n'est pas lui-même super-admin.
     */
    private function refuserSiMasque(User $user): void
    {
        abort_if($user->estMasque() && ! auth()->user()->hasRole('super-admin'), 404);
    }

    /** Le compte possède-t-il déjà un rôle non attribuable (ex. enseignant) ? Son rôle est alors figé. */
    private function aRoleVerrouille(User $user): bool
    {
        return $user->roles->contains(
            fn($role) => in_array(mb_strtolower($role->name), self::ROLES_NON_ATTRIBUABLES, true)
        );
    }

    // 🔹 Liste des utilisateurs pour DataTable et vue
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::visibles()->with(['roles', 'personne']) // super-admin masqué de la liste
                ->when($request->role, fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', $request->role)))
                ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
                ->byStatut($request->statut); // ← filtre Actifs / Désactivés (scope du modèle User)

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('name', fn($user) => $user->name ?? '—') // utilise l'accessor existant
                ->addColumn(
                    'roles',
                    fn($user) =>
                    $user->roles->map(fn($r) => '<span class="badge bg-info">' . e($r->name) . '</span>')->implode(' ')
                )
                // Booléen explicite pour l'interrupteur "Statut" du tableau
                ->editColumn('est_actif', fn($user) => (bool) $user->est_actif)
                ->addColumn(
                    'action',
                    fn($user) =>
                    view('admin.user.partials.actions', ['user' => $user])->render()
                )
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        // Filtre de la liste : tous les rôles sauf ceux masqués (super-admin)
        $roles = Role::whereNotIn(DB::raw('LOWER(name)'), User::ROLES_MASQUES)->orderBy('name')->get();
        $rolesAttribuables = $this->rolesAttribuables(); // à utiliser pour tout choix de rôle à attribuer
        return view('admin.user.index', compact('roles', 'rolesAttribuables'));
    }

    // 🔹 Statistiques utilisateurs (AJAX)
    public function stats(Request $request)
    {
        $users = User::visibles();

        if ($request->date) {
            $users->whereDate('created_at', $request->date);
        }

        return response()->json([
            'total' => $users->count(),
            'admins' => (clone $users)->whereHas('roles', fn($q) => $q->where('name', 'Admin'))->count(),
            'others' => (clone $users)->whereDoesntHave('roles', fn($q) => $q->where('name', 'Admin'))->count(),
        ]);
    }

    // 🔹 Récupérer un utilisateur pour modal EDIT (AJAX)
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->refuserSiMasque($user);

        return response()->json($user);
    }

    // 🔹 Page de création (Personne + compte)
    public function create(): View
    {
        $roles = $this->rolesAttribuables();

        return view('admin.user.create', compact('roles'));
    }

    // 🔹 Créer un utilisateur : état civil (Personne) puis compte rattaché.
    //    Le mot de passe est généré automatiquement et envoyé par e-mail avec l'identifiant.

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules($request), $this->messages());

        $motDePasse = self::MOT_DE_PASSE_PAR_DEFAUT;

        try {
            $user = DB::transaction(function () use ($data, $request, $motDePasse) {
                $personne = Personne::create($this->personneData($data));

                $user = new User([
                    'personne_id' => $personne->id,
                    'email' => $data['email'],
                    'password' => Hash::make($motDePasse),
                    'mode' => 'dark',
                    // Compte créé par un administrateur : adresse considérée comme vérifiée
                    // (sinon le middleware "verified" bloquerait l'accès sans qu'aucun e-mail ne soit envoyé)
                    'email_verified_at' => now(),
                ]);
                $user->est_actif = $request->boolean('est_actif', true);
                $user->save();

                $user->syncRoles([$data['role']]);

                return $user;
            });
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['general' => 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.']);
        }

        // Envoi des identifiants, une fois le compte enregistré. L'échec de l'envoi ne doit pas
        // annuler la création : on prévient l'administrateur.
        try {
            $user->notify(new CompteCreeNotification($motDePasse));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('admin.user.index')->with(
                'warning',
                "Utilisateur créé, mais l'e-mail n'a pas pu être envoyé à {$user->email}. "
                    . "Le mot de passe par défaut est à lui transmettre."
            );
        }

        return redirect()->route('admin.user.index')->with(
            'success',
            "Utilisateur créé. Ses identifiants ont été envoyés à {$user->email}."
        );
    }

    // 🔹 Page de modification
    public function edit(User $user): View
    {
        $user->load(['personne', 'roles']);
        $this->refuserSiMasque($user);
        $roles = $this->rolesAttribuables();
        $roleVerrouille = $this->aRoleVerrouille($user);

        return view('admin.user.edit', compact('user', 'roles', 'roleVerrouille'));
    }

    // 🔹 Mettre à jour un utilisateur (état civil + compte)
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->load(['personne', 'roles']);
        $this->refuserSiMasque($user);
        $data = $request->validate($this->rules($request, $user), $this->messages());

        // Sur son propre compte : ni changement de rôle, ni désactivation (risque de verrouillage)
        $estMoi = $user->is($request->user());
        // Rôle figé : son propre compte, ou un compte qui a déjà un rôle non attribuable (enseignant)
        $roleFige = $estMoi || $this->aRoleVerrouille($user);

        try {
            DB::transaction(function () use ($data, $request, $user, $estMoi, $roleFige) {
                if ($user->personne) {
                    $user->personne->update($this->personneData($data));
                } else {
                    // Ancien compte sans état civil : on le crée maintenant
                    $user->personne_id = Personne::create($this->personneData($data))->id;
                }

                $user->email = $data['email'];

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                if (! $estMoi) {
                    $user->est_actif = $request->boolean('est_actif');
                }

                $user->save();

                if (! $roleFige) {
                    $user->syncRoles([$data['role']]);
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['general' => 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.']);
        }

        return redirect()->route('admin.user.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /* =====================================================
     |        RÈGLES DE VALIDATION (création + édition)
     ===================================================== */

    private function rules(Request $request, ?User $user = null): array
    {
        $personneId = $user?->personne?->id;
        $estMoi = $user && $user->is($request->user());
        $roleFige = $user && ($estMoi || $this->aRoleVerrouille($user));

        return [
            'nationalite_type' => ['required', Rule::in(['nationale', 'internationale'])],
            'pays_nationalite' => [
                Rule::requiredIf(fn() => $request->input('nationalite_type') === 'internationale'),
                'nullable',
                'string',
                'max:100',
            ],

            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'date_naissance' => ['required', 'date', 'before:today'],
            'lieu_naissance' => ['required', 'string', 'max:150'],

            'piece_type' => ['required', Rule::in(['cnib', 'passeport'])],
            'piece_numero' => [
                'required',
                'string',
                'max:30',
                Rule::unique('personnes')
                    ->where('piece_type', $request->input('piece_type'))
                    ->ignore($personneId),
            ],

            'telephone_indicatif' => ['required', 'string', 'max:6'],
            'telephone' => ['required', 'string', 'max:20'],

            'adresse' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:100'],
            'pays_residence' => ['required', 'string', 'max:100'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            // À l'édition : facultatif. À la création : généré automatiquement (aucun champ dans le formulaire).
            'password' => $user
                ? ['nullable', 'confirmed', Rules\Password::defaults()]
                : ['nullable'],

            // Rôle figé (compte perso, ou rôle enseignant) : champ désactivé dans le formulaire, donc non envoyé
            'role' => $roleFige ? ['nullable'] : [
                'required',
                Rule::exists('roles', 'name'),
                // Contrôle côté serveur (insensible à la casse) : le formulaire seul ne suffit pas
                function ($attribute, $value, $fail) {
                    $role = mb_strtolower((string) $value);

                    if ($role === 'enseignant') {
                        $fail('Le rôle « ' . $value . ' » ne peut pas être attribué ici : les enseignants se gèrent depuis le module Enseignants.');
                    } elseif ($role === 'user') {
                        $fail('Le rôle « ' . $value . ' » est attribué automatiquement lors de l\'inscription des candidats : il ne peut pas être choisi ici.');
                    } elseif (in_array($role, User::ROLES_MASQUES, true)) {
                        $fail('Le rôle « ' . $value . ' » ne peut pas être attribué depuis cette page.');
                    }
                },
            ],
            'est_actif' => ['nullable', 'boolean'],
        ];
    }

    private function messages(): array
    {
        return [
            'pays_nationalite.required' => 'Le pays de nationalité est requis pour une nationalité internationale.',
            'piece_numero.unique' => 'Ce numéro de pièce est déjà associé à un compte existant.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'role.exists' => 'Le rôle sélectionné est invalide.',
        ];
    }

    /**
     * Génère un mot de passe temporaire aléatoire (14 caractères, cryptographiquement sûr) :
     * au moins une majuscule, une minuscule, un chiffre et un symbole ; sans caractères ambigus (0/O, 1/l/I).
     *
     * Pour utiliser à la place le mot de passe par défaut fixe, remplacer le corps par :
     *     return self::MOT_DE_PASSE_PAR_DEFAUT;
     */
    private function genererMotDePasse(int $longueur = 14): string
    {
        $familles = [
            'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'abcdefghijkmnopqrstuvwxyz',
            '23456789',
            '@#$%&*?!',
        ];
        $tous = implode('', $familles);

        // Un caractère de chaque famille, puis complément aléatoire
        $mdp = array_map(fn($f) => $f[random_int(0, strlen($f) - 1)], $familles);
        while (count($mdp) < $longueur) {
            $mdp[] = $tous[random_int(0, strlen($tous) - 1)];
        }

        // Mélange (Fisher-Yates avec random_int)
        for ($i = count($mdp) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$mdp[$i], $mdp[$j]] = [$mdp[$j], $mdp[$i]];
        }

        return implode('', $mdp);
    }

    /**
     * Données de la table "personnes" extraites des champs validés.
     */
    private function personneData(array $data): array
    {
        return [
            'nationalite_type' => $data['nationalite_type'],
            'pays_nationalite' => $data['nationalite_type'] === 'internationale'
                ? $data['pays_nationalite']
                : 'Burkina Faso',
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'],
            'date_naissance' => $data['date_naissance'],
            'lieu_naissance' => $data['lieu_naissance'],
            'piece_type' => $data['piece_type'],
            'piece_numero' => $data['piece_numero'],
            'telephone_indicatif' => $data['telephone_indicatif'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'] ?? null,
            'ville' => $data['ville'] ?? null,
            'pays_residence' => $data['pays_residence'],
        ];
    }


    // 🔹 Supprimer un utilisateur (AJAX)
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->refuserSiMasque($user);

        // On ne peut pas supprimer son propre compte (risque de se verrouiller hors de l'application)
        if ($user->is($request->user())) {
            return response()->json(
                ['message' => 'Vous ne pouvez pas supprimer votre propre compte.'],
                422
            );
        }

        $user->delete();

        return response()->json(['success' => true]);
    }

    public function inscription()
    {
        return view('auth.inscription');
    }

    /**
     * Traite l'inscription : crée la Personne puis le User rattaché.
     */
    public function storeInscription(Request $request): RedirectResponse
    {
        $request->validate([
            'nationalite_type' => ['required', Rule::in(['nationale', 'internationale'])],
            'pays_nationalite' => [
                Rule::requiredIf(fn() => $request->input('nationalite_type') === 'internationale'),
                'nullable',
                'string',
                'max:100',
            ],

            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'sexe' => ['required', Rule::in(['M', 'F'])],
            'date_naissance' => ['required', 'date', 'before:-15 years'],
            'lieu_naissance' => ['required', 'string', 'max:150'],

            'piece_type' => ['required', Rule::in(['cnib', 'passeport'])],
            'piece_numero' => [
                'required',
                'string',
                'max:30',
                Rule::unique('personnes')->where('piece_type', $request->input('piece_type')),
            ],

            'telephone_indicatif' => ['required', 'string', 'max:6'],
            'telephone' => ['required', 'string', 'max:20'],

            'adresse' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:100'],
            'pays_residence' => ['required', 'string', 'max:100'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ], [
            'date_naissance.before' => 'Le candidat doit avoir au moins 15 ans.',
            'pays_nationalite.required' => 'Le pays de nationalité est requis pour un candidat international.',
            'piece_numero.unique' => 'Ce numéro de pièce est déjà associé à un compte existant.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        try {
            $user = DB::transaction(function () use ($request) {
                $personne = Personne::create([
                    'nationalite_type' => $request->nationalite_type,
                    'pays_nationalite' => $request->input('nationalite_type') === 'internationale'
                        ? $request->pays_nationalite
                        : 'Burkina Faso',
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'sexe' => $request->sexe,
                    'date_naissance' => $request->date_naissance,
                    'lieu_naissance' => $request->lieu_naissance,
                    'piece_type' => $request->piece_type,
                    'piece_numero' => $request->piece_numero,
                    'telephone_indicatif' => $request->telephone_indicatif,
                    'telephone' => $request->telephone,
                    'adresse' => $request->adresse,
                    'ville' => $request->ville,
                    'pays_residence' => $request->pays_residence,
                ]);

                return User::create([
                    'personne_id' => $personne->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            });
        } catch (QueryException $e) {
            report($e);

            // Code 23000 = violation de contrainte d'intégrité (unique, FK, etc.)
            if ($e->getCode() === '23000') {
                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['piece_numero' => 'Ce numéro de pièce est déjà associé à un compte existant.']);
            }

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['general' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.']);
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['general' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.']);
        }

        $user->assignRole('user');

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }

    /**
     * Réinitialise le mot de passe d'un utilisateur au mot de passe par défaut.
     * Réservé (par la route) aux super-administrateurs. Répond en JSON pour le modal de la liste.
     */
    public function resetPassword(Request $request, User $user)
    {
        // Pour son propre compte, on passe par la page Profil
        if ($user->is($request->user())) {
            return response()->json(
                ['message' => 'Pour changer votre propre mot de passe, utilisez la page Profil.'],
                422
            );
        }

        $user->forceFill([
            'password' => Hash::make(self::MOT_DE_PASSE_PAR_DEFAUT),
            // Invalide les connexions « Se souvenir de moi » déjà ouvertes
            'remember_token' => Str::random(60),
        ])->save();

        // Trace d'audit (jamais le mot de passe lui-même)
        Log::info('Mot de passe réinitialisé par un administrateur.', [
            'administrateur_id' => $request->user()->id,
            'utilisateur_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Le mot de passe a été réinitialisé.',
            'password' => self::MOT_DE_PASSE_PAR_DEFAUT,
        ]);
    }

    /**
     * Active / désactive un compte.
     * Répond en JSON pour l'interrupteur AJAX du tableau, et par une redirection sinon.
     */
    public function toggle(Request $request, User $user)
    {
        // On ne peut pas se désactiver soi-même (risque de se verrouiller hors de l'application)
        if ($user->is($request->user())) {
            $message = 'Vous ne pouvez pas désactiver votre propre compte.';

            return $request->expectsJson()
                ? response()->json(['message' => $message], 422)
                : back()->with('error', $message);
        }

        $user->est_actif = ! $user->est_actif;
        $user->save();

        $message = $user->est_actif
            ? 'Le compte a été activé.'
            : "Le compte a été désactivé : l'utilisateur ne peut plus se connecter.";

        return $request->expectsJson()
            ? response()->json(['est_actif' => $user->est_actif, 'message' => $message])
            : back()->with('success', $message);
    }
}
