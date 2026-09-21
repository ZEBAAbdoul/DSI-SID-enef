<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemoignagesSeeder extends Seeder
{
    public function run(): void
    {
        $temoignages = [
            [
                'email' => 'rouamba@gmail.com',
                'contenu' => 'À l\'ENEF, nous avons appris le SIG et la télédétection sur des cas concrets. Dès le premier semestre, je produisais mes propres cartes d\'occupation des sols.',
                'auteur' => 'Boudasida R.',
                'fonction' => 'Ancienne élève, Ingénieure Géomaticienne',
                'note' => 5,
                'formation_concernee' => 'Master en Systèmes d\'Information Géographique',
                'ordre' => 1,
                'est_publie' => true,
            ],
            [
                'email' => 'user@enef.bf',
                'contenu' => 'Les cours sur la finance carbone m\'ont ouvert des perspectives que je n\'imaginais pas. Les enseignants sont disponibles et les études de cas sont très concrètes.',
                'auteur' => 'Ibrahim S.',
                'fonction' => 'Élève en Master 2',
                'note' => 4,
                'formation_concernee' => 'Finance Carbone et Projets Climatiques',
                'ordre' => 2,
                'est_publie' => true,
            ],
            [
                'email' => 'enseignant@enef.bf',
                'contenu' => 'Une formation exigeante mais très professionnalisante. Les stages sur le terrain nous ont préparés à la réalité du métier d\'inspecteur.',
                'auteur' => 'Fatimata K.',
                'fonction' => 'Promotion 2023, Inspectrice des Eaux et Forêts',
                'note' => 5,
                'formation_concernee' => 'Aménagement Forestier Durable',
                'ordre' => 3,
                'est_publie' => true,
            ],
            [
                'email' => 'se@enef.bf',
                'contenu' => 'Ce que j\'ai appris à l\'ENEF, je l\'applique directement dans mon travail. Les sorties terrain et les travaux pratiques font toute la différence.',
                'auteur' => 'Salif Z.',
                'fonction' => 'Ancien élève, Chargé de projet en ONG environnementale',
                'note' => 5,
                'formation_concernee' => 'Gestion des Ressources Naturelles',
                'ordre' => 4,
                'est_publie' => true,
            ],
            [
                'email' => 'sc@enef.bf',
                'contenu' => 'J\'ai choisi l\'ENEF pour sa réputation dans la sous-région et je n\'ai pas été déçue. L\'encadrement est sérieux et l\'ambiance de promotion est excellente.',
                'auteur' => 'Mariam C.',
                'fonction' => 'Élève en 2ᵉ année',
                'note' => 5,
                'formation_concernee' => 'Politiques Forestières et Gouvernance',
                'ordre' => 5,
                'est_publie' => true,
            ],
            [
                'email' => 'admin@enef.bf',
                'contenu' => 'Le module de finance carbone est très complet. Il m\'a permis de comprendre les mécanismes de financement climatique et de décrocher mon premier stage dans le domaine.',
                'auteur' => 'Abdoul Karim T.',
                'fonction' => 'Ancien élève, Consultant junior en financement climatique',
                'note' => 4,
                'formation_concernee' => 'Finance Carbone',
                'ordre' => 6,
                'est_publie' => true,
            ],
            [
                'email' => 'dg@enef.bf',
                'contenu' => 'Grâce à la formation en cartographie participative, j\'anime aujourd\'hui des ateliers avec les communautés locales. Une vraie compétence de terrain.',
                'auteur' => 'Estelle B.',
                'fonction' => 'Ancienne élève, Coordinatrice de projet de développement rural',
                'note' => 5,
                'formation_concernee' => 'SIG et Télédétection',
                'ordre' => 7,
                'est_publie' => true,
            ],
        ];

        foreach ($temoignages as $temoignage) {
            $user = User::where('email', $temoignage['email'])->first();

            if (!$user) {
                $this->command->warn(
                    "Utilisateur introuvable pour le témoignage : {$temoignage['email']}"
                );

                continue;
            }

            DB::table('temoignages')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'contenu' => $temoignage['contenu'],
                'auteur' => $temoignage['auteur'],
                'fonction' => $temoignage['fonction'],
                'note' => $temoignage['note'],
                'formation_concernee' => $temoignage['formation_concernee'],
                'image_url' => $temoignage['image_url'] ?? null,
                'est_publie' => $temoignage['est_publie'],
                'ordre' => $temoignage['ordre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}