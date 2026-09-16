<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Enseignant;
use App\Models\Formation;
use App\Models\SessionFormation;
use App\Models\Matiere;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();

        if ($enseignants->isEmpty() || $matieres->isEmpty()) {
            $this->command->warn('Aucun enseignant ou matière trouvé, seeder ignoré.');
            return;
        }

        foreach ($enseignants as $enseignant) {

            $formation = Formation::inRandomOrder()->first();
            $session = SessionFormation::where('formation_id', $formation?->id)->inRandomOrder()->first();

            if (!$formation) {
                continue;
            }

            Note::factory()->count(3)->create([
                'enseignant_id' => $enseignant->id,
                'formation_id' => $formation->id,
                'session_formation_id' => $session?->id,
                'matiere_id' => $matieres->random()->id,
            ]);
        }
    }
}