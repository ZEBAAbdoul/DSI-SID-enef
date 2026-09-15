<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_users')->only('index');
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:edit_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only('destroy');
    }

    // 🔹 Liste des utilisateurs
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.utilisateurs.index', compact('users'));
    }

    // 🔹 Formulaire création utilisateur
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    // 🔹 Stockage nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'forname' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'forname' => $request->forname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mode' => $request->mode ?? 'light',
        ]);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.user.index')->with('success', 'Utilisateur créé avec succès !');
    }

    // 🔹 Formulaire édition utilisateur
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // 🔹 Mise à jour utilisateur
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'forname' => 'nullable|string|max:255',
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required','email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'nullable|array',
        ]);

        $user->name = $request->name;
        $user->forname = $request->forname;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->mode = $request->mode ?? $user->mode;
        $user->save();

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.user.index')->with('success', 'Utilisateur mis à jour avec succès !');
    }

    // 🔹 Supprimer utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Utilisateur supprimé avec succès !');
    }
}