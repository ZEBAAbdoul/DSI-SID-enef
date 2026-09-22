<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Reproduit la galerie vidéo actuelle.
     * Rejouable : la clé est url (met à jour au lieu de dupliquer).
     */
    public function run(): void
    {
        $videos = [
            [
                'titre' => 'Ceremonie de Sortie',
                'description' => null,
                'url' => 'https://www.facebook.com/reel/1887683531916847',
                'ordre' => 0,
                'est_visible' => true,
            ],
            [
                'titre' => 'Journée nationale de l\'arbre',
                'description' => "Le Colonel des Eaux et Forêts Fiédi HAKIEKOU, Directeur Général de l’Ecole Nationale des Eaux et Forêts (ENEF) et ses collègues ainsi que les stagiaires, partenaires et populations riveraines mobilisés pour répondre à l’appel du Président du Faso, <<planter 5 millions d'arbres en une heure>>",
                'url' => 'https://www.facebook.com/reel/1286850389439165',
                'ordre' => 1,
                'est_visible' => true,
            ],
        ];

        foreach ($videos as $video) {
            Video::updateOrCreate(
                ['url' => $video['url']],
                $video
            );
        }
    }
}