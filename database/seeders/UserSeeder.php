<?php

namespace Database\Seeders;

use App\Models\Personne;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Rôles (firstOrCreate = sûr même si RoleSeeder n'a pas encore tourné)
        foreach (['super-admin', 'admin', 'dg', 'sg', 'se', 'sc', 'enseignant', 'user'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $this->createUser(
            prenom: 'Abdoul-Abass',
            nom: 'ZEBA',
            email: 'zeba@gmail.com',
            pieceNumero: 'B00000001',
            role: 'super-admin',
        );

        $this->createUser(
            prenom: 'Boudasida',
            nom: 'ROUAMBA',
            email: 'rouamba@gmail.com',
            pieceNumero: 'B000000038',
            role: 'user',
        );

        $this->createUser(
            prenom: 'Administrateur',
            nom: 'ENEF',
            email: 'admin@enef.bf',
            pieceNumero: 'B00000002',
            role: 'admin',
        );

        $this->createUser(
            prenom: 'Directeur',
            nom: 'Général',
            email: 'dg@enef.bf',
            pieceNumero: 'B00000003',
            role: 'dg',
        );

        $this->createUser(
            prenom: 'Secrétaire',
            nom: 'Général',
            email: 'sg@enef.bf',
            pieceNumero: 'B00000004',
            role: 'sg',
        );

        $this->createUser(
            prenom: 'Utilisateur',
            nom: 'SE',
            email: 'se@enef.bf',
            pieceNumero: 'B00000005',
            role: 'se',
        );

        $this->createUser(
            prenom: 'Utilisateur',
            nom: 'SC',
            email: 'sc@enef.bf',
            pieceNumero: 'B00000006',
            role: 'sc',
        );

        $this->createUser(
            prenom: 'Utilisateur',
            nom: 'Enseignant',
            email: 'enseignant@enef.bf',
            pieceNumero: 'B00000008',
            role: 'enseignant',
        );

        $this->createUser(
            prenom: 'Utilisateur',
            nom: 'Standard',
            email: 'user@enef.bf',
            pieceNumero: 'B00000007',
            role: 'user',
        );
    }

    /**
     * Crée une Personne + un User rattaché, puis lui assigne un rôle.
     */
    private function createUser(
        string $prenom,
        string $nom,
        string $email,
        string $pieceNumero,
        string $role,
    ): User {
        $personne = Personne::create([
            'nationalite_type'     => 'nationale',
            'pays_nationalite'     => 'Burkina Faso',
            'nom'                  => $nom,
            'prenom'               => $prenom,
            'sexe'                 => 'M',
            'date_naissance'       => '1990-01-01',
            'lieu_naissance'       => 'Ouagadougou',
            'piece_type'           => 'cnib',
            'piece_numero'         => $pieceNumero,
            'telephone_indicatif'  => '+226',
            'telephone'            => '70000000',
            'ville'                => 'Bobo-Dioulasso',
            'pays_residence'       => 'Burkina Faso',
        ]);

        $user = User::create([
            'id'          => Str::uuid(),
            'personne_id' => $personne->id,
            'email'       => $email,
            'password'    => bcrypt('enef@enef2026'),
        ]);

        $user->assignRole($role);

        return $user;
    }
}
