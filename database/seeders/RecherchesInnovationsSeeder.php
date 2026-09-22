<?php

namespace Database\Seeders;

use App\Models\RechercheInnovation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecherchesInnovationsSeeder extends Seeder
{
    /**
     * Reproduit le contenu actuel de la rubrique « Recherche & Innovation ».
     * Rejouable : la clé est le slug (met à jour au lieu de dupliquer).
     */
    public function run(): void
    {
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : null;

        $items = [
            [
                'slug'       => 'memoire-de-fin-detude',
                'titre'      => 'Memoire de fin d\'etude',
                'chapo'      => 'Le mémoire universitaire sur l\'environnement',
                'contenu'    => 'L’axe « Mémoire environnementale », porte sur la capacité des systèmes environnementaux à faire persister une information (la « mémoire environnementale ») sur leur état et leur modification, leur réponse à un événement ou une évolution. Suivant la nature des systèmes étudiés, la mémoire environnementale couvre des gammes chronologiques, une résolution, une continuité, une précision plus ou moins grande et sont sensibles à des événements de nature ou d’intensité différente. Cependant, du fait de leur complexité, les relations entre l’événement et son enregistrement est complexe et souvent ambiguë (p. ex. anthropique vs climat notamment). Ce constat impose alors fréquemment un recours croisé à plusieurs types de mémoires pour caractériser un même phénomène et en améliorer sa connaissance. L’objectif de cet axe est de faciliter la mise en relation des travaux menés au sein des équipes sur différents types d’archives environnementales, qu’il s’agisse des archives du sol (sédiments, sols sensu stricto), des archives biologiques (biocénoses actuelles et fossiles), des archives documentaires (textes, plans, cartes, photos, vidéo...) ou de la mémoire vivante (mémoire orale).',
                'type'       => 'recherche',
                'photo'      => [
                    'recherches_innovations/photos/tlTB5Uhkb8LcxMmG7TwhyJ0yyleRyIyOt8DRd06g.webp',
                    'recherches_innovations/photos/kE4CNlLS08g6bbEJwXT4Rw7prgdwxMBVZ5mU037g.jpg',
                    'recherches_innovations/photos/XaGgcEoNwmlwcKVMa1gGDwXDmHOTcxqj3M38dvHU.webp',
                ],
                'url_video'  => 'https://www.facebook.com/reel/1032699442754352',
                'document'   => 'recherches_innovations/documents/memoire.pdf',
                'is_publiee' => true,
                'created_at' => '2026-09-22 09:26:59',
                'updated_at' => '2026-09-22 09:38:00',
            ],
        ];

        foreach ($items as $item) {
            RechercheInnovation::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'titre'      => $item['titre'],
                    'chapo'      => $item['chapo'],
                    'contenu'    => $item['contenu'],
                    'type'       => $item['type'],
                    'photo'      => $item['photo'],
                    'url_video'  => $item['url_video'],
                    'document'   => $item['document'],
                    'is_publiee' => $item['is_publiee'],
                    'created_by' => $userId,
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ]
            );
        }
    }
}
