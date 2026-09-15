<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    // 🔹 Liste des utilisateurs pour DataTable et vue
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')
                ->when($request->role, fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', $request->role)))
                ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date));

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn(
                    'roles',
                    fn($user) =>
                    $user->roles->map(fn($r) => '<span class="badge bg-info">' . $r->name . '</span>')->implode(' ')
                )
                ->addColumn(
                    'action',
                    fn($user) =>
                    view('admin.user.partials.actions', ['user' => $user])->render()
                )
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        $roles = Role::all();
        return view('admin.user.index', compact('roles'));
    }

    // 🔹 Statistiques utilisateurs (AJAX)
    public function stats(Request $request)
    {
        $users = User::query();

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
        return response()->json($user);
    }

    // 🔹 Créer un utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mode' => 'light',
        ]);

        $user->assignRole([$request->role]);

        // Pas de JSON, on peut juste retourner succès pour le toast
        return redirect()->back()->with('success', 'Utilisateur ajouté avec succès !');
    }


    // 🔹 Mettre à jour un utilisateur (AJAX)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->syncRoles([$request->role]);

        // 🔹 Retour classique avec message flash
        return redirect()->back()->with('success', 'Utilisateur mis à jour avec succès.');
    }


    // 🔹 Supprimer un utilisateur (AJAX)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
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
    /**
 * Traite l'inscription : crée la Personne puis le User rattaché.
 */
public function storeInscription(Request $request): RedirectResponse
{
    $request->validate([
        'nationalite_type' => ['required', Rule::in(['nationale', 'internationale'])],
        'pays_nationalite' => [
            Rule::requiredIf(fn () => $request->input('nationalite_type') === 'internationale'),
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
}
