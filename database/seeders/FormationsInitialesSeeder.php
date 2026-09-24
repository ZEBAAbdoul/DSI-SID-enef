<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Formation;

/**
 * Seeder des formations initiales de l'ENEF (cycles professionnels).
 *
 * - Filière Eaux et forêts (code EF) : 3 cycles
 * - Filière Environnement (code ENV) : 3 cycles
 *
 * Une formation = un cycle. Les options du cycle sont listées dans `contenu_programme`.
 * Aucune nouvelle colonne n'est nécessaire, tout tient dans les colonnes existantes :
 *   - duree          : durée de la formation
 *   - public_cible   : conditions d'accès
 *   - cout_indicatif : frais de scolarité par an (F CFA)
 *   - objectifs      : diplôme délivré
 *   - resume         : récapitulatif (cycle, filière, diplôme, durée, frais en F CFA et €)
 *
 * ⚠️ Prérequis : CategoriesFormationSeeder (catégorie "Formation initiale") et FilieresSeeder
 *    (à lancer avant : les filières sont recherchées par leur `code`, EF et ENV).
 * ⚠️ À vérifier : la valeur de `type` ('academique') doit correspondre à celle utilisée
 *    par ton module Formations. `filiere_id` doit être dans le $fillable du modèle Formation.
 *
 * Utilise updateOrCreate sur `code_module` : relançable sans doublons.
 */
class FormationsInitialesSeeder extends Seeder
{
    public function run(): void
    {
        $categorieId = DB::table('categories_formation')->where('slug', 'formation-initiale')->value('id');
        $userId = DB::table('users')->value('id'); // null si aucun utilisateur en base

        // Filières créées par FilieresSeeder, recherchées par code
        $filiereGrnId = DB::table('filieres')->where('code', 'EF')->value('id');
        $filiereEnvId = DB::table('filieres')->where('code', 'ENV')->value('id');

        if (! $filiereGrnId || ! $filiereEnvId) {
            throw new \RuntimeException('Filières introuvables (codes EF et ENV) : lancez d\'abord FilieresSeeder.');
        }

        $sansOption = 'Aucune option : cycle sans spécialisation.';

        $optionsEauxForets = "Options :\n"
            . "- Foresterie\n"
            . "- Valorisation des chaînes de valeurs forestières\n"
            . "- Génie forestier et gestion durable des terres\n"
            . "- Faune et aires protégées\n"
            . "- Conservation des écosystèmes aquatiques";

        $formations = [
            // ───────────── Filière : Eaux et forêts (EF) ─────────────
            [
                'code_module' => 'FI-GRN-AEF',
                'filiere_id' => $filiereGrnId,
                'titre' => 'Assistants des Eaux et Forêts',
                'cycle' => 'Assistants des Eaux et Forêts',
                'filiere' => 'Gestion des ressources naturelles',
                'diplome' => 'Certificat professionnel',
                'duree' => '18 mois',
                'cout' => 316000,
                'cout_eur' => '482 €',
                'conditions' => ['BEPC', 'Agent + 5 ans d’expérience professionnelle'],
                'contenu' => $sansOption,
            ],
            [
                'code_module' => 'FI-GRN-CEF',
                'filiere_id' => $filiereGrnId,
                'titre' => 'Contrôleurs des Eaux et Forêts',
                'cycle' => 'Contrôleurs des Eaux et Forêts',
                'filiere' => 'Gestion des ressources naturelles',
                'diplome' => 'Brevet professionnel',
                'duree' => '21 mois',
                'cout' => 523000,
                'cout_eur' => '798 €',
                'conditions' => ['BAC scientifique', 'Assistant + 3 ans d’expérience professionnelle'],
                'contenu' => $optionsEauxForets,
            ],
            [
                'code_module' => 'FI-GRN-IEF',
                'filiere_id' => $filiereGrnId,
                'titre' => 'Inspecteurs des Eaux et Forêts',
                'cycle' => 'Inspecteurs des Eaux et Forêts',
                'filiere' => 'Gestion des ressources naturelles',
                'diplome' => 'Diplôme professionnel',
                'duree' => '24 mois',
                'cout' => 730000,
                'cout_eur' => '1 114 €',
                'conditions' => ['Licence scientifique', 'Contrôleur + 3 ans d’expérience professionnelle'],
                'contenu' => $optionsEauxForets,
            ],

            // ───────────── Filière : Environnement (ENV) ─────────────
            [
                'code_module' => 'FI-ENV-ATE',
                'filiere_id' => $filiereEnvId,
                'titre' => 'Agents Techniques d’Environnement',
                'cycle' => 'Agents Techniques d’Environnement',
                'filiere' => 'Gestion de l’environnement',
                'diplome' => 'Certificat professionnel',
                'duree' => '18 mois',
                'cout' => 316000,
                'cout_eur' => '482 €',
                'conditions' => ['BEPC', 'Agent + 5 ans d’expérience professionnelle'],
                'contenu' => $sansOption,
            ],
            [
                'code_module' => 'FI-ENV-TSE',
                'filiere_id' => $filiereEnvId,
                'titre' => 'Techniciens Supérieurs de l’Environnement',
                'cycle' => 'Techniciens Supérieurs de l’Environnement',
                'filiere' => 'Gestion de l’environnement',
                'diplome' => 'Brevet professionnel',
                'duree' => '21 mois',
                'cout' => 523000,
                'cout_eur' => '798 €',
                'conditions' => ['BAC scientifique', 'Agent Technique + 3 ans d’expérience professionnelle'],
                'contenu' => "Options :\n- Écologie urbaine et écocitoyenneté\n- Gestion des pollutions et nuisances",
            ],
            [
                'code_module' => 'FI-ENV-IE',
                'filiere_id' => $filiereEnvId,
                'titre' => 'Inspecteurs de l’Environnement',
                'cycle' => 'Inspecteurs de l’Environnement',
                'filiere' => 'Gestion de l’environnement',
                'diplome' => 'Diplôme professionnel',
                'duree' => '24 mois',
                'cout' => 730000,
                'cout_eur' => '1 114 €',
                'conditions' => ['Licence scientifique', 'Technicien Supérieur + 3 ans d’expérience professionnelle'],
                'contenu' => "Options :\n- Écologie urbaine et écocitoyenneté\n- Gestion des pollutions et nuisances\n- Hygiène sécurité environnement",
            ],
        ];

        foreach ($formations as $f) {
            $conditions = "Conditions d’accès :\n- " . implode("\n- ", $f['conditions']);

            $resume = sprintf(
                'Formation initiale du cycle %s (filière %s), sanctionnée par un %s. Durée : %s. Frais de scolarité : %s F CFA/an (%s).',
                $f['cycle'],
                $f['filiere'],
                $f['diplome'],
                $f['duree'],
                number_format($f['cout'], 0, ',', ' '),
                $f['cout_eur']
            );

            Formation::updateOrCreate(
                ['code_module' => $f['code_module']],
                [
                    'type' => 'academique',
                    'titre' => $f['titre'],
                    'slug' => Str::slug($f['titre']),
                    'resume' => $resume,
                    'objectifs' => 'Diplôme délivré : ' . $f['diplome'] . '.',
                    'contenu_programme' => $f['contenu'],
                    'duree' => $f['duree'],
                    'public_cible' => $conditions,
                    'cout_indicatif' => $f['cout'],
                    'statut' => 'ouverte',
                    'categorie_id' => $categorieId,
                    'filiere_id' => $f['filiere_id'],
                    'created_by' => $userId,
                ]
            );
        }

        $this->command->info(count($formations) . ' formations initiales ENEF importées/mises à jour.');
    }
}