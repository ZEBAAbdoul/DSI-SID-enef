<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActualitesSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer un utilisateur existant
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : null;

        $actualites = [
            [
                'titre' => 'Communiqué officiel : Réforme des programmes de formation',
                'type' => 'communique',
                'chapo' => "L'ENEF annonce une réforme majeure de ses programmes de formation pour mieux répondre aux défis environnementaux.",
                'contenu' => "Le Conseil d'Administration de l'ENEF a approuvé la réforme des programmes de formation. Cette réforme vise à moderniser les cursus et à les adapter aux enjeux contemporains de la gestion durable des ressources naturelles.\n\nLes nouveaux programmes intégreront des modules sur le changement climatique, l'économie circulaire, les énergies renouvelables et les technologies numériques appliquées à l'environnement.",
                'image_couverture_url' => 'actualites/reforme-formation.jpg',
                'is_publiee' => true,
                'ordre_menu' => 1,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'titre' => 'Lancement de la nouvelle formation en SIG et Télédétection',
                'type' => 'formation',
                'chapo' => "L'ENEF annonce le lancement d'une nouvelle formation de pointe en Systèmes d'Information Géographique et Télédétection, répondant aux besoins croissants du secteur.",
                'contenu' => "L'École Nationale des Eaux et Forêts (ENEF) est fière d'annoncer le lancement de sa nouvelle formation en Systèmes d'Information Géographique (SIG) et Télédétection. Cette formation innovante vise à former des experts capables de maîtriser les outils géomatiques pour la gestion durable des ressources naturelles.\n\nLa formation sera dispensée par des professionnels expérimentés et combinera des cours théoriques avec des travaux pratiques sur le terrain. Les inscriptions sont ouvertes jusqu'au 31 décembre 2026.",
                'image_couverture_url' => 'actualites/sig-formation.jpg',
                'is_publiee' => true,
                'ordre_menu' => 5,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Partenariat stratégique avec CORDAID pour la finance carbone',
                'type' => 'partenariat',
                'chapo' => "L'ENEF et CORDAID renforcent leur partenariat pour développer des projets innovants dans le domaine de la finance carbone.",
                'contenu' => "Dans le cadre de son engagement pour la lutte contre le changement climatique, l'ENEF a signé un partenariat stratégique avec CORDAID. Cette collaboration vise à développer des projets de finance carbone innovants en Afrique de l'Ouest.\n\nCe partenariat permettra également de former des experts locaux aux mécanismes de financement carbone et de compensation des émissions de gaz à effet de serre.",
                'image_couverture_url' => 'actualites/partenariat-cordaid.png',
                'is_publiee' => true,
                'ordre_menu' => 2,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Cérémonie de remise des diplômes promotion 2026',
                'type' => 'evenement',
                'chapo' => "La promotion 2026 de l'ENEF a reçu ses diplômes lors d'une cérémonie solennelle placée sous le thème de l'excellence.",
                'contenu' => "La cérémonie de remise des diplômes de la promotion 2026 s'est déroulée le 15 septembre 2026 dans les locaux de l'ENEF. Cette cérémonie a été marquée par la présence des autorités administratives, des partenaires et des familles des diplômés.\n\nAu total, 156 étudiants ont reçu leur diplôme dans les différentes filières proposées par l'école, avec un taux de réussite exceptionnel de 92%.",
                'image_couverture_url' => 'actualites/remise-diplomes.WEBP',
                'is_publiee' => true,
                'ordre_menu' => 3,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Nouveau partenariat avec l\'Université de Bordeaux',
                'type' => 'partenariat',
                'chapo' => "L'ENEF signe un accord de coopération avec l'Université de Bordeaux pour des échanges académiques et scientifiques.",
                'contenu' => "L'ENEF et l'Université de Bordeaux ont signé un accord de coopération visant à renforcer les échanges académiques et scientifiques entre les deux institutions.\n\nCet accord prévoit des programmes d'échange d'étudiants et d'enseignants-chercheurs, des projets de recherche conjoints et la co-organisation de colloques internationaux dans le domaine des sciences forestières et environnementales.",
                'image_couverture_url' => 'actualites/partenariat-bordeaux.jpg',
                'is_publiee' => true,
                'ordre_menu' => 4,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'titre' => 'Journée de l\'environnement 2026 : L\'ENEF mobilisée',
                'type' => 'evenement',
                'chapo' => "L'ENEF organise une journée de sensibilisation à l'environnement avec des activités pour toute la communauté.",
                'contenu' => "À l'occasion de la Journée Mondiale de l'Environnement, l'ENEF a organisé une série d'activités de sensibilisation et de plantation d'arbres.\n\nDes conférences-débats, des ateliers pratiques et des animations ont permis de sensibiliser les étudiants et le public aux enjeux environnementaux et à l'importance de la protection des écosystèmes.",
                'image_couverture_url' => 'actualites/journee-environnement.jpg',
                'is_publiee' => false,
                'ordre_menu' => 6,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($actualites as $actualite) {
            DB::table('actualites')->insert([
                'id' => (string) Str::uuid(),
                'slug' => Str::slug($actualite['titre']) . '-' . Str::random(6),
                'titre' => $actualite['titre'],
                'chapo' => $actualite['chapo'],
                'contenu' => $actualite['contenu'],
                'image_couverture_url' => $actualite['image_couverture_url'],
                'type' => $actualite['type'],
                'ordre_menu' => $actualite['ordre_menu'],
                'is_publiee' => $actualite['is_publiee'],
                'created_by' => $actualite['created_by'],
                'created_at' => $actualite['created_at'],
                'updated_at' => $actualite['updated_at'],
            ]);
        }
    }
}