<?php

namespace Database\Seeders;

use App\Models\UnitePedagogique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Reprend le contenu du "Guide de gestion des unités pédagogiques et de
 * production" (DFCP, juillet 2026), auparavant codé en dur dans la vue.
 *
 * Relançable sans doublons : updateOrCreate() sur le numéro d'unité.
 */
class UnitesPedagogiquesSeeder extends Seeder
{
    public function run(): void
    {
        $unites = [
            [
                'numero' => 1,
                'titre' => 'Unité pédagogique et de production forestière',
                'concept' => "Espace de production et d'apprentissage dédié aux techniques de production de plants, de champignons, à la gestion de parcelles expérimentales à vocation forestière et à la botanique forestière.",
                'objectif_general' => 'Doter les apprenants des compétences techniques et pratiques nécessaires à la production de plants forestiers et fruitiers, à la connaissance de la flore, au suivi écologique de la zone d\'application de l\'ENEF et à la valorisation des ressources botaniques et fongiques.',
                'objectifs_specifiques' => [
                    'Maîtriser l\'itinéraire technique de production de plants (implantation de la pépinière, semis, repiquage, multiplication végétative etc.)',
                    'Identifier et classer les espèces forestières et médicinales locales',
                    'Faire le suivi écologique des parcelles expérimentales',
                    'Conduire une production de champignons selon les itinéraires techniques recommandés',
                    'Sensibiliser à la conservation de la biodiversité végétale et à l\'éducation environnementale',
                ],
                'sous_unites' => [
                    ['nom' => 'Pépinière forestière', 'apps' => 'Techniques de production de plants en pépinière, Horticulture, Multiplication végétative, Reboisement'],
                    ['nom' => 'Jardin botanique', 'apps' => 'Botanique systématique et forestière, Éducation environnementale, Ethnobotanique'],
                    ['nom' => 'Bosquet de plantes médicinales', 'apps' => 'Botanique forestière, Ethnobotanique, Éducation environnementale, utilisation de plantes médicinales'],
                    ['nom' => 'Parcelles expérimentales', 'apps' => 'Suivi écologique (inventaire forestier, dendrométrie, agrostologie, aménagement forestier)'],
                    ['nom' => 'Myciculture (production de champignons)', 'apps' => 'Botanique systématique des champignons, Techniques de production de champignons'],
                ],
            ],
            [
                'numero' => 2,
                'titre' => 'Unité pédagogique et de production agroforestière',
                'concept' => 'Unité regroupant la production agricole, la gestion durable des terres et des parcelles expérimentales, au service de l\'apprentissage des techniques agroforestières et de conservation des eaux et des sols.',
                'objectif_general' => 'Doter les apprenants de compétences techniques et pratiques de production agricole et de restauration des terres dégradées, dans une approche intégrée agriculture-foresterie.',
                'objectifs_specifiques' => [
                    'Conduire des cultures pluviales, de contre-saison et maraîchères',
                    'Mettre en œuvre les techniques de gestion durable des terres (RNA, cordons pierreux, bandes enherbées, demi-lunes, zaï etc.)',
                    'Conduire des expérimentations sur parcelles (espèces fourragères, champs école)',
                    'Développer une démarche entrepreneuriale autour des productions agroforestières',
                ],
                'sous_unites' => [
                    ['nom' => 'Production agricole', 'apps' => 'Cultures pluviales et de contre-saison, Cultures maraîchères, Jardins nutritifs, Entreprenariat'],
                    ['nom' => 'Gestion durable des terres', 'apps' => 'RNA, Cordons pierreux, Bandes enherbées, Demi-lune, Zaï'],
                    ['nom' => 'Parcelles expérimentales', 'apps' => 'Expérimentation d\'espèces fourragères, Champs écoles'],
                ],
            ],
            [
                'numero' => 9,
                'titre' => 'Unité pédagogique aménagement paysager et assainissement',
                'concept' => 'Regroupe l\'aménagement paysager, la gestion des déchets (déchèterie) et une mini-STEP (Station de Traitement et d\'Épuration des eaux) au service de l\'embellissement du cadre de vie et de l\'éducation à l\'assainissement.',
                'objectif_general' => 'Développer les compétences techniques et pratiques des apprenants aux techniques d\'aménagement paysager et d\'assainissement.',
                'objectifs_specifiques' => [
                    'Maîtriser les pratiques d\'horticulture',
                    'Entretenir des espaces verts contribuant à l\'embellissement du cadre de vie',
                    'Mettre en œuvre la collecte, le tri, le stockage et la valorisation des déchets',
                    'Former les apprenants aux enjeux de l\'assainissement et de l\'hygiène du milieu',
                    'Constituer un modèle d\'aménagement paysager pour les collectivités territoriales et autres institutions',
                ],
                'sous_unites' => [
                    ['nom' => 'Aménagement paysager', 'apps' => 'Horticulture, Élaboration de plan d\'aménagement paysager, plantation et entretien des plants, Embellissement'],
                    ['nom' => 'Gestion des déchets', 'apps' => 'Collecte, transport, stockage et tri des déchets, Traitement et valorisation, Assainissement'],
                    ['nom' => 'Mini STEP', 'apps' => 'Collecte des eaux usées, traitement des eaux usées, réutilisation des eaux traitées'],
                ],
            ],
            [
                'numero' => 10,
                'titre' => 'Unité pédagogique d\'éducation environnementale',
                'concept' => 'Unité dédiée à la formation, à la sensibilisation et à l\'éducation civique et écocitoyenne du public.',
                'objectif_general' => 'Promouvoir l\'écocitoyenneté par l\'éducation environnementale.',
                'objectifs_specifiques' => [
                    'Développer les compétences techniques et pratiques des apprenants en matière d\'éducation environnementale',
                    'Sensibiliser les élèves du préscolaire, du primaire et du post primaire, les étudiants et autres aux enjeux environnementaux et au développement durable',
                    'Encourager l\'adoption de comportements écocitoyens dans les établissements scolaires, les ménages et les communautés',
                    'Évaluer les changements de comportements et l\'impact des actions d\'éducation environnementale',
                ],
                'sous_unites' => [
                    ['nom' => 'Parcours d\'éducation environnementale', 'apps' => 'Botanique forestière, Utilité des plantes, Gestion des déchets, Biodiversité, Production'],
                    ['nom' => 'Salle d\'éducation environnementale', 'apps' => 'Sensibilisation, Éducation civique et écocitoyenne'],
                ],
            ],
            [
                'numero' => 8,
                'titre' => 'Unité formation civique et militaire',
                'note' => 'à approfondir',
                'concept' => 'Utilisée pour la formation militaire initiale (FMI), le maintien en condition opérationnelle (MCO), l\'instruction au tir et le conditionnement physique des apprenants.',
                'objectif_general' => 'Doter les apprenants de la discipline, de la condition physique et des compétences militaires de base requises par le statut paramilitaire de l\'ENEF.',
                'objectifs_specifiques' => [
                    'Maîtriser les techniques de formation militaire initiale et de maintien en condition opérationnelle',
                    'Connaître le maniement et les règles de sécurité liées à l\'armement',
                    'Développer une condition physique adaptée aux exigences du métier',
                    'Intérioriser la discipline et l\'esprit de corps propres au statut paramilitaire',
                ],
                'sous_unites' => [
                    ['nom' => 'Site de formation militaire', 'apps' => 'FMI, MCO'],
                    ['nom' => 'Champ de tirs', 'apps' => 'Armement, Instruction sur les tirs'],
                    ['nom' => 'Parcours d\'obstacles', 'apps' => 'Conditionnement physique'],
                    ['nom' => 'Atelier de couture', 'apps' => 'Confection des tenues de la formation'],
                ],
            ],
            [
                'numero' => 3,
                'titre' => 'Unité pédagogique et de production animale',
                'concept' => 'Unité consacrée aux systèmes d\'élevage (bovin, petits ruminants, aviculture, aulacodiculture, apiculture), à la production de fumure organique et à l\'entreprenariat en économie circulaire.',
                'objectif_general' => 'Former les apprenants à la conduite pratique d\'élevages diversifiés et à la gestion entrepreneuriale des productions animales.',
                'objectifs_specifiques' => [
                    'Maîtriser les techniques durables d\'élevage des animaux sauvages et domestiques',
                    'Faire des expérimentations sur la production des plantes fourragères',
                    'Élaborer un compte d\'exploitation simplifié pour chaque filière animale',
                    'Appliquer les bonnes pratiques sanitaires et de bien-être animal',
                ],
                'sous_unites' => [
                    ['nom' => 'Bovine', 'apps' => 'Systèmes d\'élevage bovin, Production de fumure organique, Entreprenariat, tenue d\'un compte d\'exploitation'],
                    ['nom' => 'Petits ruminants (ovins et caprins)', 'apps' => 'Systèmes d\'élevage de petits ruminants, Fumure organique, Entreprenariat'],
                    ['nom' => 'Unité avicole', 'apps' => 'Système d\'élevage avicole, Fumure organique, Entreprenariat'],
                    ['nom' => 'Élevage conventionnel des animaux sauvages', 'apps' => 'Élevage des animaux, Entreprenariat'],
                    ['nom' => 'Apicole', 'apps' => 'Élevage des abeilles, Traitement du miel, valorisation des produits'],
                ],
            ],
            [
                'numero' => 4,
                'titre' => 'Unité pédagogique et de production piscicole',
                'concept' => 'Unité dédiée à la reproduction et au grossissement des poissons. Composée de l\'écloserie et des bassins piscicoles.',
                'objectif_general' => 'Développer une unité de référence en pisciculture permettant de former des professionnels qualifiés, de promouvoir les innovations techniques en aquaculture et d\'améliorer durablement la production halieutique.',
                'objectifs_specifiques' => [
                    'Maîtriser les méthodes de reproduction des poissons et de production d\'alevins',
                    'Montrer les techniques de production d\'aliment pour poissons aux apprenants',
                    'Conduire le grossissement, l\'alimentation et le suivi sanitaire des poissons',
                    'Suivre les paramètres physico-chimiques des bassins',
                ],
                'sous_unites' => [
                    ['nom' => 'Écloserie', 'etat' => 'Fonctionnelle', 'apps' => 'Méthodes de reproduction, Production d\'alevins, entretien des bassins, alimentation, soins, suivi'],
                    ['nom' => 'Bassins de pisciculture', 'etat' => 'Fonctionnelle', 'apps' => 'Grossissement, Alimentation, Soins, Suivi physico-chimique de l\'eau, Entreprenariat, transformation et commercialisation'],
                ],
            ],
            [
                'numero' => 7,
                'titre' => 'Le laboratoire',
                'concept' => 'Unité technique chargée des prélèvements et analyses d\'échantillons (eau, sol, organes végétaux) au service des enseignements et des unités de production de l\'École.',
                'objectif_general' => 'Former les apprenants aux techniques de prélèvement et d\'analyse de laboratoire utiles à la gestion des ressources naturelles.',
                'objectifs_specifiques' => [
                    'Maîtriser les techniques de prélèvement d\'échantillons d\'eau, de sol et d\'organes végétaux',
                    'Réaliser des analyses physico-chimiques de base en laboratoire',
                    'Interpréter les résultats d\'analyse pour orienter les pratiques de production',
                    'Respecter les règles d\'hygiène et de sécurité en laboratoire',
                ],
                'sous_unites' => [
                    ['nom' => 'Pédagogique', 'etat' => 'Opérationnelle', 'apps' => 'TP, TD (biologie, microbiologie, chimie…)'],
                    ['nom' => 'Analyse (prestation)', 'etat' => 'En cours', 'apps' => 'Techniques de prélèvement d\'échantillons, Analyses d\'échantillons (eau, sol, organes végétaux)'],
                ],
            ],
            [
                'numero' => 6,
                'titre' => 'Unité pédagogique cartographie',
                'concept' => 'Unité dédiée à la formation sur les systèmes d\'information géographique (SIG) et à la télédétection, à la conception et à l\'impression de cartes topographiques et thématiques.',
                'objectif_general' => 'Former les apprenants aux outils de cartographie, au SIG et à la télédétection nécessaires à l\'aménagement et à la gestion des ressources naturelles.',
                'objectifs_specifiques' => [
                    'Concevoir et produire des cartes topographiques et thématiques',
                    'Maîtriser les fonctionnalités de base d\'un logiciel de SIG',
                    'Exploiter des données de télédétection pour le suivi des ressources naturelles',
                    'Restituer des analyses spatiales sous forme de cartes exploitables',
                ],
                'sous_unites' => [
                    ['nom' => 'Unité Cartographie', 'etat' => 'À mettre en place', 'apps' => 'Conception et impression de cartes topographiques et thématiques, Formation en SIG et télédétection'],
                    ['nom' => 'Topographique', 'etat' => 'À mettre en place', 'apps' => 'Utilisation de matériel topographique (boussoles, théodolite, GPS…), levés topographiques'],
                ],
            ],
        ];

        foreach ($unites as $ordre => $unite) {
            UnitePedagogique::updateOrCreate(
                ['numero' => $unite['numero']],
                [
                    'titre' => $unite['titre'],
                    'slug' => Str::slug($unite['titre']) . '-' . $unite['numero'],
                    'note' => $unite['note'] ?? null,
                    'concept' => $unite['concept'],
                    'objectif_general' => $unite['objectif_general'],
                    'objectifs_specifiques' => $unite['objectifs_specifiques'] ?? [],
                    'sous_unites' => $unite['sous_unites'] ?? [],
                    'ordre' => $ordre,
                    'est_publie' => true,
                ]
            );
        }
    }
}