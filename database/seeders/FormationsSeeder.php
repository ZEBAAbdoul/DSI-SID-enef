<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Formation;

/**
 * Seeder des formations ACADÉMIQUES (Master, Licence...).
 *
 * Les formations continues (programmées et à la carte) sont gérées
 * exclusivement par FormationsCatalogueSeeder, à partir du catalogue
 * officiel ENEF. Ce seeder ne doit donc contenir que type = academique,
 * pour éviter tout doublon conceptuel avec les modules R1/R2.
 *
 * Aligné sur la même structure que FormationsCatalogueSeeder :
 * - utilise le modèle Formation::updateOrCreate (relançable sans doublons)
 * - renseigne les colonnes ajoutées par la migration
 *   2026_09_17_000000_add_catalogue_fields_to_formations_table.php
 *   (code_module, techniques, places_min, places_max, periode_indicative)
 * - conserve image_url et mots_cles (spécifiques aux formations académiques)
 *
 * ⚠️ Prérequis : exécuter CategoriesFormationSeeder avant celui-ci.
 */
class FormationsSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->value('id'); // null si aucun utilisateur en base

        $categorieProgrammeeId = DB::table('categories_formation')->where('nom', 'Formation programmée')->value('id');

        // Récupérer les IDs des filières avec leur code
        $filieres = DB::table('filieres')->pluck('id', 'code')->toArray();

        $formations = [
            [
                'code_module' => 'ACAD-SIG-M2',
                'type' => 'academique',
                'filiere_code' => 'SIG',
                'categorie_id' => $categorieProgrammeeId,
                'titre' => 'Master en Systèmes d\'Information Géographique',
                'resume' => 'Formation approfondie en SIG et télédétection appliquée aux ressources naturelles.',
                'objectifs' => 'Maîtriser les outils SIG avancés pour l\'analyse spatiale et la gestion des ressources.',
                'contenu_programme' => "Module 1 : Introduction aux SIG\nModule 2 : Télédétection\nModule 3 : Analyse spatiale\nModule 4 : Applications pratiques",
                'duree' => '2 ans',
                'public_cible' => 'Ingénieurs forestiers, géographes, environnementalistes',
                'techniques' => null,
                'cout_indicatif' => 1500000,
                'places_min' => null,
                'places_max' => null,
                'periode_indicative' => null,
                'image_url' => 'formations/sig-master.jpg',
                'mots_cles' => 'SIG, télédétection, cartographie, analyse spatiale',
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'ACAD-GRN-L3',
                'type' => 'academique',
                'filiere_code' => 'GRE',
                'categorie_id' => $categorieProgrammeeId,
                'titre' => 'Licence en Gestion des Ressources Naturelles',
                'resume' => 'Formation fondamentale en gestion durable des ressources naturelles.',
                'objectifs' => 'Former des cadres capables de gérer durablement les ressources naturelles.',
                'contenu_programme' => "Semestre 1 : Écologie fondamentale\nSemestre 2 : Gestion des écosystèmes\nSemestre 3 : Politiques environnementales\nSemestre 4 : Projets de terrain",
                'duree' => '3 ans',
                'public_cible' => 'Bacheliers scientifiques',
                'techniques' => null,
                'cout_indicatif' => 1200000,
                'places_min' => null,
                'places_max' => null,
                'periode_indicative' => null,
                'image_url' => 'formations/gestion-ressources.png',
                'mots_cles' => 'ressources naturelles, écologie, gestion, développement durable',
                'statut' => 'ouverte',
            ],
        ];

        foreach ($formations as $data) {
            $filiereId = $data['filiere_code'] ? ($filieres[$data['filiere_code']] ?? null) : null;
            unset($data['filiere_code']);

            Formation::updateOrCreate(
                ['code_module' => $data['code_module']],
                array_merge($data, [
                    'slug' => Str::slug($data['titre']),
                    'filiere_id' => $filiereId,
                    'created_by' => $userId,
                ])
            );
        }

        $this->command->info(count($formations) . ' formations académiques importées/mises à jour.');
    }
}