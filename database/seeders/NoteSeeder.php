<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use App\Models\Formation;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\SessionFormation;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();
        $eleves = User::inRandomOrder()->limit(10)->get();

        if ($enseignants->isEmpty() || $matieres->isEmpty() || $eleves->isEmpty()) {
            $this->command->warn('Données insuffisantes (enseignant, matière ou élève) : seeder Note ignoré.');
            return;
        }

        // On note uniquement sur les formations qui ont au moins une session enregistrée
        $sessions = SessionFormation::with('formation')->get();

        if ($sessions->isEmpty()) {
            $this->command->warn('Aucune session de formation trouvée : seeder Note ignoré.');
            return;
        }

        foreach ($eleves as $eleve) {
            // Chaque élève est noté sur une session tirée au hasard
            $session = $sessions->random();

            if (!$session->formation) {
                continue;
            }

            foreach ($matieres as $matiere) {
                Note::create([
                    'enseignant_id' => $enseignants->random()->id,
                    'eleve_id' => $eleve->id,
                    'formation_id' => $session->formation->id,
                    'session_formation_id' => $session->id,
                    'matiere_id' => $matiere->id,
                    'type_evaluation' => fake()->randomElement(['controle', 'examen', 'tp']),
                    'note' => fake()->randomFloat(2, 8, 20),
                    'note_max' => 20,
                    'date_evaluation' => now()->subDays(fake()->numberBetween(1, 90)),
                ]);
            }
        }
    }
}