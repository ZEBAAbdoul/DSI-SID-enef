<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FormationsSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer un utilisateur existant
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : Str::uuid()->toString();

        // Récupérer les IDs des catégories existantes
        $categories = DB::table('categories_formation')->pluck('id', 'nom')->toArray();

        // Récupérer les IDs des filières avec leur code
        $filieres = DB::table('filieres')->pluck('id', 'code')->toArray();

        // Définir les IDs des catégories
        $formationProgrammeeId = $categories['Formation programmée'] ?? null;
        $formationALaCarteId = $categories['Formation à la carte'] ?? null;

        $formations = [
            [
                'type' => 'academique',
                'filiere_code' => 'SIG', // Utiliser le code au lieu de l'index
                'categorie_id' => $formationProgrammeeId,
                'titre' => 'Master en Systèmes d\'Information Géographique',
                'resume' => 'Formation approfondie en SIG et télédétection appliquée aux ressources naturelles',
                'objectifs' => 'Maîtriser les outils SIG avancés pour l\'analyse spatiale et la gestion des ressources',
                'contenu_programme' => "Module 1: Introduction aux SIG\nModule 2: Télédétection\nModule 3: Analyse spatiale\nModule 4: Applications pratiques",
                'duree' => '2 ans',
                'public_cible' => 'Ingénieurs forestiers, géographes, environnementalistes',
                'cout_indicatif' => 1500000.00,
                'image_url' => 'formations/sig-master.jpg',
                'mots_cles' => 'SIG, télédétection, cartographie, analyse spatiale',
                'statut' => 'ouverte',
            ],
            [
                'type' => 'continue_programmee',
                'filiere_code' => 'FGE',
                'categorie_id' => $formationProgrammeeId,
                'titre' => 'Finance Carbone et Projets Climatiques',
                'resume' => 'Formation sur les mécanismes de finance carbone et les projets de réduction des émissions',
                'objectifs' => 'Comprendre les marchés carbone, élaborer des projets de compensation carbone',
                'contenu_programme' => "Jour 1: Introduction au finance carbone\nJour 2: Mécanismes de marché\nJour 3: Élaboration de projets\nJour 4: Études de cas",
                'duree' => '4 jours',
                'public_cible' => 'Chefs de projet, ONG, entreprises, consultants',
                'cout_indicatif' => 750000.00,
                'image_url' => 'formations/finance-carbone.jpg',
                'mots_cles' => 'carbone, climat, finance, compensation, REDD+',
                'statut' => 'ouverte',
            ],
            [
                'type' => 'continue_a_la_carte',
                'filiere_code' => null, // Pas de filière spécifique
                'categorie_id' => $formationALaCarteId,
                'titre' => 'Foresterie Communautaire et Gestion Participative',
                'resume' => 'Formation sur les approches participatives de gestion forestière communautaire',
                'objectifs' => 'Renforcer les compétences en gestion forestière participative et développement local',
                'contenu_programme' => 'Module sur mesure selon les besoins du client',
                'duree' => 'Sur mesure (5-15 jours)',
                'public_cible' => 'Communautés locales, ONG, services forestiers',
                'cout_indicatif' => 500000.00,
                'image_url' => 'formations/foresterie-communautaire.jpg',
                'mots_cles' => 'foresterie communautaire, participative, gestion, développement local',
                'statut' => 'brouillon',
            ],
            [
                'type' => 'academique',
                'filiere_code' => 'GRE',
                'categorie_id' => $formationProgrammeeId,
                'titre' => 'Licence en Gestion des Ressources Naturelles',
                'resume' => 'Formation fondamentale en gestion durable des ressources naturelles',
                'objectifs' => 'Former des cadres capables de gérer durablement les ressources naturelles',
                'contenu_programme' => "Semestre 1: Écologie fondamentale\nSemestre 2: Gestion des écosystèmes\nSemestre 3: Politiques environnementales\nSemestre 4: Projets de terrain",
                'duree' => '3 ans',
                'public_cible' => 'Bacheliers scientifiques',
                'cout_indicatif' => 1200000.00,
                'image_url' => 'formations/gestion-ressources.png',
                'mots_cles' => 'ressources naturelles, écologie, gestion, développement durable',
                'statut' => 'ouverte',
            ],
            [
                'type' => 'continue_programmee',
                'filiere_code' => 'EDD',
                'categorie_id' => $formationProgrammeeId,
                'titre' => 'Aménagement Forestier Durable',
                'resume' => 'Formation pratique sur les techniques d\'aménagement forestier durable',
                'objectifs' => 'Maîtriser les outils et méthodes d\'aménagement forestier',
                'contenu_programme' => "Module 1: Inventaire forestier\nModule 2: Plan d'aménagement\nModule 3: Suivi-évaluation\nModule 4: Certification forestière",
                'duree' => '6 semaines',
                'public_cible' => 'Ingénieurs forestiers, techniciens, gestionnaires d\'aires protégées',
                'cout_indicatif' => 900000.00,
                'image_url' => 'formations/amenagement-forestier.jpg',
                'mots_cles' => 'aménagement, foresterie, inventaire, certification',
                'statut' => 'cloturee',
            ],
        ];

        foreach ($formations as $formationData) {
            // Récupérer l'ID de la filière à partir du code
            $filiereId = null;
            if ($formationData['filiere_code'] && isset($filieres[$formationData['filiere_code']])) {
                $filiereId = $filieres[$formationData['filiere_code']];
            }

            // Créer la formation
            DB::table('formations')->insert([
                'id' => (string) Str::uuid(),
                'type' => $formationData['type'],
                'filiere_id' => $filiereId,
                'categorie_id' => $formationData['categorie_id'],
                'titre' => $formationData['titre'],
                'slug' => Str::slug($formationData['titre']) . '-' . Str::random(6),
                'resume' => $formationData['resume'],
                'objectifs' => $formationData['objectifs'],
                'contenu_programme' => $formationData['contenu_programme'],
                'duree' => $formationData['duree'],
                'public_cible' => $formationData['public_cible'],
                'cout_indicatif' => $formationData['cout_indicatif'],
                'image_url' => $formationData['image_url'],
                'mots_cles' => $formationData['mots_cles'],
                'statut' => $formationData['statut'],
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}