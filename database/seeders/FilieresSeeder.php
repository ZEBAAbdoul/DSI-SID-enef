<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilieresSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = [
            [
                'nom'           => 'Eaux et forêts',
                'code'          => 'EF',
                'description'   => $this->formatDescription([
                    'Formation en foresterie',
                    'Valorisation des chaînes de valeurs forestières',
                    'Génie forestier et gestion durable des terres',
                    'Faune et aires protégées',
                    'Conservation des écosystèmes aquatiques',
                    'Géomatique, cartographie numérique',
                    'Télédétection et analyse spatiale pour la gestion des ressources naturelles',
                ]),
                'responsable'   => 'Dr. Mamadou Diallo',
                'email_contact' => 'sig@enef.bf',
                'est_active'    => true,
            ],

            [
                'nom'           => 'Environnement',
                'code'          => 'ENV',
                'description'   => $this->formatDescription([
                    'Écologie urbaine et écocitoyenneté',
                    'Gestion des pollutions et nuisances',
                    'Hygiène, sécurité et environnement',
                ]),
                'responsable'   => 'Pr. Aïssata Traoré',
                'email_contact' => 'foresterie@enef.bf',
                'est_active'    => true,
            ],
        ];

        foreach ($filieres as $filiere) {
            DB::table('filieres')->insert([
                'id'            => (string) Str::uuid(),
                'nom'           => $filiere['nom'],
                'slug'          => Str::slug($filiere['nom']),
                'code'          => $filiere['code'],
                'description'   => $filiere['description'],
                'responsable'   => $filiere['responsable'],
                'email_contact' => $filiere['email_contact'],
                'est_active'    => $filiere['est_active'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    /**
     * Transforme une liste de points en description formatée avec puces.
     */
    private function formatDescription(array $points): string
    {
        return implode("\n", array_map(fn ($point) => "• {$point}", $points));
    }
}