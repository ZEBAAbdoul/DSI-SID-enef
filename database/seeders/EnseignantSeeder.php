<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnseignantSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->limit(5)->get();

        if ($users->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé : seeder Enseignant ignoré.');
            return;
        }

        $specialites = [
            'Gestion des ressources naturelles',
            'SIG et télédétection',
            'Sylviculture et aménagement forestier',
            'Droit de l\'environnement',
            'Étude d\'impact environnemental',
        ];

        foreach ($users as $index => $user) {
            Enseignant::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'matricule' => 'ENS-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'specialite' => $specialites[$index] ?? 'Formation générale',
                    'telephone' => '+226 70 00 00 ' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                    'statut' => 'actif',
                ]
            );
        }
    }
}