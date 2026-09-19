<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            [
                'titre' => 'Campus principal de l\'ENEF',
                'description' => 'Vue d\'ensemble du campus et des bâtiments administratifs.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 1,
                'est_visible' => true,
            ],
            [
                'titre' => 'Séance de travaux pratiques en forêt',
                'description' => 'Les stagiaires en pleine session d\'inventaire forestier sur le terrain.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 2,
                'est_visible' => true,
            ],
            [
                'titre' => 'Salle de cours SIG et télédétection',
                'description' => 'Formation pratique sur les outils de cartographie numérique.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 3,
                'est_visible' => true,
            ],
            [
                'titre' => 'Cérémonie de remise des diplômes 2025',
                'description' => 'Les lauréats de la promotion 2025 lors de la cérémonie officielle.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 4,
                'est_visible' => true,
            ],
            [
                'titre' => 'Pépinière pédagogique',
                'description' => 'Espace dédié à la production de plants pour les travaux pratiques.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 5,
                'est_visible' => true,
            ],
            [
                'titre' => 'Bibliothèque et centre de documentation',
                'description' => 'Espace de lecture et de recherche mis à disposition des élèves.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 6,
                'est_visible' => true,
            ],
            [
                'titre' => 'Mission de terrain — Réhabilitation d\'un site minier',
                'description' => 'Équipe d\'étudiants lors d\'une mission d\'appui-conseil.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 7,
                'est_visible' => true,
            ],
            [
                'titre' => 'Journée portes ouvertes',
                'description' => 'Accueil des futurs candidats lors de la journée d\'information annuelle.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 8,
                'est_visible' => true,
            ],
            [
                'titre' => 'Atelier de sylviculture appliquée',
                'description' => 'Démonstration de techniques de gestion durable des peuplements forestiers.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 9,
                'est_visible' => true,
            ],
            [
                'titre' => 'Vie associative des élèves',
                'description' => 'Activité organisée par le bureau des élèves de l\'établissement.',
                'image_url' => 'photos/photo1.jpg',
                'ordre' => 10,
                'est_visible' => false,
            ],
        ];

        foreach ($photos as $photo) {
            Photo::create($photo);
        }
    }
}