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
                'nom' => 'Systèmes d\'Information Géographique',
                'code' => 'SIG',
                'description' => 'Formation en géomatique, cartographie numérique, télédétection et analyse spatiale pour la gestion des ressources naturelles.',
                'responsable' => 'Dr. Mamadou Diallo',
                'email_contact' => 'sig@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Foresterie et Gestion des Écosystèmes',
                'code' => 'FGE',
                'description' => 'Formation en gestion durable des forêts, écologie forestière, aménagement et conservation des écosystèmes.',
                'responsable' => 'Pr. Aïssata Traoré',
                'email_contact' => 'foresterie@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Gestion des Ressources en Eau',
                'code' => 'GRE',
                'description' => 'Formation en hydrologie, gestion intégrée des ressources en eau, qualité de l\'eau et aménagement des bassins versants.',
                'responsable' => 'Dr. Ibrahim Sawadogo',
                'email_contact' => 'eau@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Environnement et Développement Durable',
                'code' => 'EDD',
                'description' => 'Formation en politiques environnementales, évaluation environnementale, développement durable et changement climatique.',
                'responsable' => 'Pr. Fatoumata Bâ',
                'email_contact' => 'edd@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Agroforesterie et Systèmes Agro-sylvo-pastoraux',
                'code' => 'ASP',
                'description' => 'Formation en agroforesterie, systèmes de production intégrés, agrosylviculture et pastoralisme durable.',
                'responsable' => 'Dr. Oumarou Zongo',
                'email_contact' => 'agroforesterie@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Biodiversité et Conservation',
                'code' => 'BIO',
                'description' => 'Formation en biologie de la conservation, gestion des aires protégées, écologie de la biodiversité et restauration des écosystèmes.',
                'responsable' => 'Dr. Kady Ouédraogo',
                'email_contact' => 'biodiversite@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Gestion des Déchets et Économie Circulaire',
                'code' => 'GDE',
                'description' => 'Formation en gestion durable des déchets, recyclage, économie circulaire et valorisation des ressources.',
                'responsable' => 'Dr. Moussa Coulibaly',
                'email_contact' => 'dechets@enef.bf',
                'est_active' => false,
            ],
            [
                'nom' => 'Énergies Renouvelables et Efficacité Énergétique',
                'code' => 'ERE',
                'description' => 'Formation en énergies solaires, éoliennes, biomasse, efficacité énergétique et transition énergétique.',
                'responsable' => 'Pr. Abdoulaye Diop',
                'email_contact' => 'energies@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Politiques Forestières et Gouvernance',
                'code' => 'PFG',
                'description' => 'Formation en politiques forestières, gouvernance des ressources naturelles, décentralisation et gestion participative.',
                'responsable' => 'Dr. Mariam Koné',
                'email_contact' => 'politiques@enef.bf',
                'est_active' => true,
            ],
            [
                'nom' => 'Écotourisme et Valorisation du Patrimoine Naturel',
                'code' => 'ECO',
                'description' => 'Formation en écotourisme, développement touristique durable, valorisation des patrimoines naturels et culturels.',
                'responsable' => 'Dr. Amadou Diallo',
                'email_contact' => 'ecotourisme@enef.bf',
                'est_active' => true,
            ],
        ];

        foreach ($filieres as $filiere) {
            DB::table('filieres')->insert([
                'id' => (string) Str::uuid(),
                'nom' => $filiere['nom'],
                'slug' => Str::slug($filiere['nom']),
                'code' => $filiere['code'],
                'description' => $filiere['description'],
                'responsable' => $filiere['responsable'],
                'email_contact' => $filiere['email_contact'],
                'est_active' => $filiere['est_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}