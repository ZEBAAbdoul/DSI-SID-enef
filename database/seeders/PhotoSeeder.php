<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Reproduit la galerie photo actuelle.
     * Rejouable : la clé est image_url (met à jour au lieu de dupliquer).
     */
    public function run(): void
    {
        $photos = [
            [
                'titre' => 'Campus principal de l\'ENEF',
                'description' => 'Vue d\'ensemble du campus et des bâtiments administratifs.',
                'image_url' => 'photos/drLgqmApLt8xW58yMDWY8FJ3mZPekNLvH4wpPrNe.jpg',
                'ordre' => 1,
                'est_visible' => true,
            ],
            [
                'titre' => 'Séance de travaux pratiques en forêt',
                'description' => 'Les stagiaires en pleine session d\'inventaire forestier sur le terrain.',
                'image_url' => 'photos/vNsRs7frSZmlsWPEE6g8mO4uSrIFA3UmABiubDVL.jpg',
                'ordre' => 2,
                'est_visible' => true,
            ],
            [
                'titre' => 'Salle de cours SIG et télédétection',
                'description' => 'Formation pratique sur les outils de cartographie numérique.',
                'image_url' => 'photos/Yfrcb7D6pLvmomprjYRx9krOEPgxE9LMXFYc95Y3.jpg',
                'ordre' => 3,
                'est_visible' => true,
            ],
            [
                'titre' => 'Cérémonie de remise des diplômes 2025',
                'description' => 'Les lauréats de la promotion 2025 lors de la cérémonie officielle.',
                'image_url' => 'photos/nXodQpQpISWcJn1OqBcVzwuq3s9uex8YK3x4kpXm.jpg',
                'ordre' => 4,
                'est_visible' => true,
            ],
            [
                'titre' => 'Pépinière pédagogique',
                'description' => 'Espace dédié à la production de plants pour les travaux pratiques.',
                'image_url' => 'photos/snrGewDT2hoB23M0xpNDY4zg06hOyDKTViDs8A0f.jpg',
                'ordre' => 5,
                'est_visible' => true,
            ],
            [
                'titre' => 'Bibliothèque et centre de documentation',
                'description' => 'Espace de lecture et de recherche mis à disposition des élèves.',
                'image_url' => 'photos/fL9bI7IOgBVjbfcdqB98KKtba5SmZFlEhjZ1pgIN.jpg',
                'ordre' => 6,
                'est_visible' => true,
            ],
            [
                'titre' => 'Mission de terrain — Réhabilitation d\'un site minier',
                'description' => 'Équipe d\'étudiants lors d\'une mission d\'appui-conseil.',
                'image_url' => 'photos/WzItP33ZXLEbiYaPFsvk7pIXsttPafB0hYYvLXkV.jpg',
                'ordre' => 7,
                'est_visible' => true,
            ],
            [
                'titre' => 'Journée portes ouvertes',
                'description' => 'Accueil des futurs candidats lors de la journée d\'information annuelle.',
                'image_url' => 'photos/GbCZYYVTa2TTz4zzGDpucceR0KG0rszgaWweU1hv.jpg',
                'ordre' => 8,
                'est_visible' => true,
            ],
            [
                'titre' => 'Atelier de sylviculture appliquée',
                'description' => 'Démonstration de techniques de gestion durable des peuplements forestiers.',
                'image_url' => 'photos/DE9hABJBMoZIVy7tHIwtLVF25OlDUwxqmWBhN8xl.jpg',
                'ordre' => 9,
                'est_visible' => true,
            ],
            [
                'titre' => 'Vie associative des élèves',
                'description' => 'Activité organisée par le bureau des élèves de l\'établissement.',
                'image_url' => 'photos/xDvbcKUXVQb0wrgyCxhxR1aSwjRDQCrujfBLglIk.jpg',
                'ordre' => 10,
                'est_visible' => false,
            ],
        ];

        foreach ($photos as $photo) {
            Photo::updateOrCreate(
                ['image_url' => $photo['image_url']],
                $photo
            );
        }
    }
}