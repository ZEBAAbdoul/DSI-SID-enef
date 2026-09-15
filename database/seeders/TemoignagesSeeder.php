<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemoignagesSeeder extends Seeder
{
    public function run(): void
    {
        $temoignages = [
            [
                'contenu' => 'L\'ENEF nous a formé au SIG et à la télédétection en conditions réelles.',
                'auteur' => 'Ancienne stagiaire',
                'fonction' => 'Ingénieure Géomaticienne',
                'note' => 5,
                'formation_concernee' => 'Master en Systèmes d\'Information Géographique',
                'ordre' => 1,
                'est_publie' => true,
            ],
            [
                'contenu' => 'Un partenariat solide pour nos projets de finance carbone.',
                'auteur' => 'CORDAID',
                'fonction' => 'Partenaire International',
                'note' => 4,
                'formation_concernee' => 'Finance Carbone et Projets Climatiques',
                'ordre' => 2,
                'est_publie' => true,
            ],
            [
                'contenu' => 'Une formation exigeante et très professionnalisante.',
                'auteur' => 'Inspecteur des Eaux et Forêts',
                'fonction' => 'Promotion 2023',
                'note' => 5,
                'formation_concernee' => 'Aménagement Forestier Durable',
                'ordre' => 3,
                'est_publie' => true,
            ],
            [
                'contenu' => 'Les compétences acquises à l\'ENEF sont directement applicables sur le terrain.',
                'auteur' => 'Chef de Projet',
                'fonction' => 'ONG Environnementale',
                'note' => 5,
                'formation_concernee' => 'Gestion des Ressources Naturelles',
                'ordre' => 4,
                'est_publie' => true,
            ],
            [
                'contenu' => 'Une référence en matière de formation environnementale en Afrique de l\'Ouest.',
                'auteur' => 'Directeur Régional',
                'fonction' => 'Ministère de l\'Environnement',
                'note' => 5,
                'formation_concernee' => 'Politiques Forestières et Gouvernance',
                'ordre' => 5,
                'est_publie' => true,
            ],
            [
                'contenu' => 'L\'approche pratique et les études de cas réels font la différence.',
                'auteur' => 'Consultant International',
                'fonction' => 'Expert en Financement Climatique',
                'note' => 4,
                'formation_concernee' => 'Finance Carbone',
                'ordre' => 6,
                'est_publie' => true,
            ],
            [
                'contenu' => 'Grâce à l\'ENEF, notre équipe maîtrise désormais les outils de cartographie participative.',
                'auteur' => 'Coordinatrice',
                'fonction' => 'Projet de Développement Rural',
                'note' => 5,
                'formation_concernee' => 'SIG et Télédétection',
                'ordre' => 7,
                'est_publie' => true,
            ],
        ];

        foreach ($temoignages as $temoignage) {
            DB::table('temoignages')->insert([
                'id' => (string) Str::uuid(),
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