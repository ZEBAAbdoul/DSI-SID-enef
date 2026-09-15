<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionsFormationSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer un utilisateur existant (créateur)
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : null;

        if (!$userId) {
            $this->command->warn("Aucun utilisateur trouvé : 'created_by' sera NULL.");
        }

        // Récupérer les IDs des formations par titre
        $formations = DB::table('formations')->pluck('id', 'titre')->toArray();

        $sessions = [
            // === Master en Systèmes d'Information Géographique ===
            [
                'formation_titre'    => 'Master en Systèmes d\'Information Géographique',
                'date_debut'         => '2026-10-01',
                'date_fin'           => '2028-06-30',
                'lieu'               => 'Ouagadougou - Campus principal',
                'places_totales'     => 30,
                'places_disponibles' => 30,
                'statut'             => 'ouverte',
            ],
            [
                'formation_titre'    => 'Master en Systèmes d\'Information Géographique',
                'date_debut'         => '2025-10-01',
                'date_fin'           => '2027-06-30',
                'lieu'               => 'Ouagadougou - Campus principal',
                'places_totales'     => 30,
                'places_disponibles' => 0,
                'statut'             => 'complete',
            ],

            // === Finance Carbone et Projets Climatiques ===
            [
                'formation_titre'    => 'Finance Carbone et Projets Climatiques',
                'date_debut'         => '2026-03-10',
                'date_fin'           => '2026-03-13',
                'lieu'               => 'Ouagadougou - Salle de conférence',
                'places_totales'     => 25,
                'places_disponibles' => 25,
                'statut'             => 'ouverte',
            ],
            [
                'formation_titre'    => 'Finance Carbone et Projets Climatiques',
                'date_debut'         => '2025-11-05',
                'date_fin'           => '2025-11-08',
                'lieu'               => 'Bobo-Dioulasso - Centre de formation',
                'places_totales'     => 20,
                'places_disponibles' => 3,
                'statut'             => 'ouverte',
            ],

            // === Foresterie Communautaire et Gestion Participative ===
            [
                'formation_titre'    => 'Foresterie Communautaire et Gestion Participative',
                'date_debut'         => '2026-04-15',
                'date_fin'           => '2026-04-29',
                'lieu'               => 'Sur site (à définir avec le client)',
                'places_totales'     => 15,
                'places_disponibles' => 15,
                'statut'             => 'ouverte',
            ],

            // === Licence en Gestion des Ressources Naturelles ===
            [
                'formation_titre'    => 'Licence en Gestion des Ressources Naturelles',
                'date_debut'         => '2026-12-01',
                'date_fin'           => '2029-06-30',
                'lieu'               => 'Ouagadougou - Campus principal',
                'places_totales'     => 50,
                'places_disponibles' => 50,
                'statut'             => 'ouverte',
            ],
            [
                'formation_titre'    => 'Licence en Gestion des Ressources Naturelles',
                'date_debut'         => '2025-10-01',
                'date_fin'           => '2028-06-30',
                'lieu'               => 'Ouagadougou - Campus principal',
                'places_totales'     => 50,
                'places_disponibles' => 0,
                'statut'             => 'cloturee',
            ],

            // === Aménagement Forestier Durable ===
            [
                'formation_titre'    => 'Aménagement Forestier Durable',
                'date_debut'         => '2025-09-01',
                'date_fin'           => '2025-10-15',
                'lieu'               => 'Ouagadougou - Centre forestier',
                'places_totales'     => 20,
                'places_disponibles' => 0,
                'statut'             => 'cloturee',
            ],
            [
                'formation_titre'    => 'Aménagement Forestier Durable',
                'date_debut'         => '2026-09-01',
                'date_fin'           => '2026-10-15',
                'lieu'               => 'Ouagadougou - Centre forestier',
                'places_totales'     => 25,
                'places_disponibles' => 25,
                'statut'             => 'ouverte',
            ],
        ];

        foreach ($sessions as $sessionData) {
            // Récupérer l'ID de la formation par titre
            $formationId = $formations[$sessionData['formation_titre']] ?? null;

            // Skip si la formation n'existe pas
            if (!$formationId) {
                $this->command->warn("Formation introuvable : {$sessionData['formation_titre']}");
                continue;
            }

            DB::table('sessions_formation')->insert([
                'id'                 => (string) Str::uuid(),
                'formation_id'       => $formationId,
                'date_debut'         => $sessionData['date_debut'],
                'date_fin'           => $sessionData['date_fin'],
                'lieu'               => $sessionData['lieu'],
                'places_totales'     => $sessionData['places_totales'],
                'places_disponibles' => $sessionData['places_disponibles'],
                'statut'             => $sessionData['statut'],
                'created_by'         => $userId,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}