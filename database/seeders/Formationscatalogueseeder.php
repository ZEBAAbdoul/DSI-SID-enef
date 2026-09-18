<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Formation;

/**
 * Seeder du catalogue de formation continue ENEF — Année académique 2025-2026.
 * Source : CATALOGUE_FC_ENEF_VF.doc (Direction de la Formation Continue et du Partenariat)
 *
 * - Rubrique 1 (R1) : formations continues PROGRAMMÉES -> type = continue_programmee
 * - Rubrique 2 (R2) : formations continues À LA CARTE  -> type = continue_a_la_carte
 *
 * N'utilise QUE des colonnes scalaires (string/text/int/decimal) déjà
 * compatibles avec la table `formations` existante + les 5 colonnes
 * ajoutées par la migration 2026_09_17_000000_add_catalogue_fields_to_formations_table.php
 * (code_module, techniques, places_min, places_max, periode_indicative).
 * Aucun cast JSON n'est requis sur le modèle Formation.
 *
 * ⚠️ Prérequis : exécuter CategoriesFormationSeeder avant celui-ci, pour
 * que les catégories "Formation programmée" / "Formation à la carte"
 * existent déjà (categorie_id y est rattaché automatiquement ci-dessous).
 * filiere_id est laissé à null : aucun module du catalogue ne correspond
 * clairement à une filière unique — à assigner manuellement si besoin.
 *
 * Utilise updateOrCreate sur `code_module` : relançable sans doublons.
 */
class FormationsCatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $categorieProgrammeeId = DB::table('categories_formation')->where('nom', 'Formation programmée')->value('id');
        $categorieALaCarteId = DB::table('categories_formation')->where('nom', 'Formation à la carte')->value('id');
        $userId = DB::table('users')->value('id'); // null si aucun utilisateur en base — colonne created_by nullable

        $modules = [
            [
                'code_module' => 'R1M1',
                'type' => 'continue_programmee',
                'titre' => 'SUIVI DES INDICATEURS DES PLANS DE GESTION ENVIRONNEMENTALE ET SOCIALE (PGES)',
                'resume' => 'Cette formation devrait à terme permettre aux agents à avoir une démarche scientifique consistant à observer l’évolution de certaines composantes des milieux biologique, physique et humain affectés par la réalisation d’un projet à partir du PGES.',
                'objectifs' => 'Renforcer les capacités des agents du ministère.

Objectifs pédagogiques :
- identifier les actions et composantes devant faire l’objet d’un suivi.
- décrire les activités et moyens prévus pour suivre les effets réels.
- analyser le chronogramme de mise en œuvre du suivi.
- analyser l’ensemble des mesures et moyens pour faire face aux circonstances imprévues et réadapter la réalisation des mesures d’atténuation ;
- analyser le mécanisme d’exécution du programme de suivi environnemental.',
                'contenu_programme' => '- identification des actions et composantes devant faire l’objet d’un suivi.
- description des activités et moyens prévus pour suivre les effets réels.
- méthodes d’échantillonnage et d’analyse requises.
- analyse du chronogramme de mise en œuvre du suivi.
- analyse de l’ensemble des mesures et moyens pour faire face aux circonstances imprévues et réadapter la réalisation des mesures d’atténuation;
- analyse du mécanisme d’exécution du programme de suivi environnemental.',
                'duree' => '40 heures',
                'public_cible' => 'Responsable d’école, promoteur de ferme agrosylvopastoral, producteurs individuels, associations, groupements…',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => 200000,
                'places_min' => 10,
                'places_max' => 50,
                'periode_indicative' => '20 au 25 octobre',
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R1M2',
                'type' => 'continue_programmee',
                'titre' => 'INSTALLATION D’UN JARDIN NUTRITIF',
                'resume' => 'Cette formation est destinée à toute personne qui souhaite créer ou améliorer un jardin nutritif, en particulier pour cultiver de bons aliments et apprendre à commercialiser les produits du jardin. Il peut s’agir de responsable d’école (jardin scolaire), d’un responsable de jardin, d’un groupe de professeurs, de parents et de membres de la communauté, issus d’une école ou de plusieurs écoles différentes.',
                'objectifs' => 'Il s’agit d’accompagner les acteurs à l’installation et à l’entretien d’un jardin nutritif.

Objectifs pédagogiques :
- A la fin de la séance, les participants seront capables d’installer un jardin nutritif.',
                'contenu_programme' => '- contenu théorique du jardin nutritif
- sensibilisation des acteurs
- produits à cultiver
- élaboration du plan
- mobilisation des matériaux
- démarrage des travaux
- entretien du jardin
- récolte
- possibilités de valorisation',
                'duree' => '40 heures',
                'public_cible' => 'Responsable QHSE des entreprises Responsable de production des entreprises',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => 350000,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => '08 au 12 septembre',
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R1M3',
                'type' => 'continue_programmee',
                'titre' => 'QUALITE HYGIENNE SECURITE ENVIRONNEMENT',
                'resume' => 'L’outil QHSE est indispensable dans la performance sociale, économique et la certification d’une entreprise. Son application améliore la sécurité du personnel, l’environnement, la visibilité et la vente des produits de l’entreprise au plan national et international.',
                'objectifs' => 'Outiller les acteurs opérationnels et les managers afin d’assurer une conformité réglementaire, prévenir les risques et promouvoir une culture de sécurité et de développement durable.

Objectifs pédagogiques :
- Définir la politique et des objectifs QHSE
- Comprendre les processus d’apparition de risques.
- Établir des Plans QHSE selon les normes ISO',
                'contenu_programme' => '- Introduction à la gestion QHSE : concepts et enjeux
- Normes et réglementations applicables (ISO, réglementations locales)
- Méthodologies d’évaluation des risques
- Techniques de prévention et de gestion des incidents
- Gestion de la Qualité : outils et standards
- Hygiène et ergonomie au travail
- Sécurité : équipements, procédures, plans d’évacuation
- Environnement : gestion des déchets, réduction des impacts
- Culture QHSE et engagement des collaborateurs',
                'duree' => '08 heures',
                'public_cible' => 'Institutions financières Industriels PME-PMI',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => 200000,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => '26 juillet',
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R1M4',
                'type' => 'continue_programmee',
                'titre' => 'SECTEUR PRIVE ET FINANCE CLIMAT',
                'resume' => 'La finance climatique est un domaine en pleine croissance. Elle évoque les sujets tels que les investissements durables, la modélisation des risques climatiques, les obligations vertes, et les mécanismes de marché du carbone. Elle permet de comprendre également comment les investissements et les flux financiers soutiennent la lutte contre le changement climatique et la place du secteur privé dans le financement des projets climat.',
                'objectifs' => 'Renforcer les capacités des acteurs du secteur privé à comprendre leur place et rôle dans les mécanismes de financement des projets climat.

Objectifs pédagogiques :
- les impacts des changements climatiques sur l’environnement et les sociétés humaines.
- des mécanismes de la finance climat.
- la place, le rôle et les opportunités dans la finance climat pour les institutions financières et les entrepreneurs.',
                'contenu_programme' => '- Introduction au changement climatique et ses impacts.
- Introduction à la finance climat.
- Mécanismes de financement climatique.
- Rôle, place et opportunités du secteur privé dans la finance climat.',
                'duree' => '40 heures',
                'public_cible' => 'Chercheurs Responsables d’ONG Acteurs de la société civile Acteurs de développement Personnel des collectivités',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => 350000,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => '18 au 23 aout',
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R1M5',
                'type' => 'continue_programmee',
                'titre' => 'NOTES CONCEPTUELLES DE PROJETS CLIMAT',
                'resume' => 'Le financement de la lutte contre les changements climatiques est l\'un des aspects les plus importants des efforts déployés à l\'échelle mondiale pour faire face au défi des changements climatiques. Maitriser les mécanismes et les procédures des différents canaux de mobilisation de ce financement permet aux acteurs nationaux de mobiliser davantage les ressources financières auprès des structures de financement du climat.',
                'objectifs' => 'Renforcer la capacité des acteurs nationaux à comprendre et à accéder aux sources de financement pertinentes pour leurs actions climatiques.

Objectifs pédagogiques :
- La compréhension claire de ce qu’est le financement climatique et de ses termes clés.
- La connaissance des différentes sources de financement climatique.
- La description des principales considérations à prendre en compte pour accéder au financement climatique.
- La rédaction d’une note conceptuelle de projet climat.',
                'contenu_programme' => '- Introduction à l’action climatique au Burkina Faso.
- Généralités sur la finance climat.
- Introduction aux concepts de justification climatique.
- Financement de l’action climatique : options et sources
- Canevas de notes conceptuelles selon les sources de financement climat.
- Élaboration de notes conceptuelles selon les sources de financement climat.',
                'duree' => '40 heures',
                'public_cible' => 'Directeurs d’exploitation, chef de projets ou toutes personnes désireuses de se faire former.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M1',
                'type' => 'continue_a_la_carte',
                'titre' => 'GESTION ENVIRONNEMENTALE',
                'resume' => 'Permettre aux participants de bien intégrer la question environnementale dans la planification de leurs activités.',
                'objectifs' => 'Outiller les participants en bonnes pratiques en matière de gestion environnementale et de les prédisposer à leur application.

Objectifs pédagogiques :
- expliquer les notions en environnement en lien avec le secteur d’activités ;
- situer le cadre juridique sur le plan environnemental applicable au secteur d’activités ;
- élaborer un plan de gestion environnementale en lien avec le secteur d’activités ;
- opérationnaliser le plan de gestion environnementale.',
                'contenu_programme' => '- notion en Environnement en lien avec la gestion avec le secteur d’activité concerné
- cadre juridique sur le plan environnemental applicable au secteur d’activité concerné
- gestion des déchets solides et des effluents dans le secteur d’activité concerné
- évaluation des Impacts liés à la mauvaise gestion des déchets Solides et des effluents du secteur d’activité concerné
- élaboration et mise en œuvre d\'un plan de gestion environnementale
- mise en place d’une Cellule environnementale fonctionnelle dans l’organisation/structure.',
                'duree' => '40 heures',
                'public_cible' => 'Responsable QSE Responsable environnement Responsable de production Responsable de station de traitement',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M2',
                'type' => 'continue_a_la_carte',
                'titre' => 'GESTION DES EFFLUENTS LIQUIDES : TRAITEMENT AVANT REJETS',
                'resume' => 'Cette formation vise à renforcer des connaissances en gestion des effluents liquide en adéquation avec le contexte de chaque secteur d’activité des différents participants.',
                'objectifs' => 'Outiller les participants à la mise en place d’un système de gestion performant des effluent liquides de les prédisposer à un bon contrôle de la pollution.

Objectifs pédagogiques :
- mettre en application les réglementations en cours ;
- identifier à chaque étape de traitement des effluents les technologies dédiées, leur adéquation avec le contexte de l’entreprise ;
- optimiser le rendement de sa station ;
- diminuer les rejets ;
- découvrir les dernières techniques innovantes.',
                'contenu_programme' => '- introduction à la formation du traitement des effluents liquides industriels
- les aspects techniques du traitement des eaux industrielles
- la chaîne de traitement des effluents liquides industriels
- le post-traitement des effluents liquides industriels',
                'duree' => '40 heures',
                'public_cible' => 'Agent publics. Agents des collectivités locales. Entrepreneurs, acteurs du secteur privé et des ONG et association, Responsable QSE, Responsable environnement & production',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M3',
                'type' => 'continue_a_la_carte',
                'titre' => 'TRAITEMENT ET VALORISATION DES DECHETS SOLIDES',
                'resume' => 'La gestion efficace des déchets solides est un enjeu majeur pour la protection de l’environnement, la santé publique et le développement durable. La valorisation des déchets, en particulier, permet de réduire leur volume, de produire de l’énergie ou des matériaux recyclés, contribuant ainsi à une gestion intégrée et durable.',
                'objectifs' => 'Renforcer les capacités des acteurs de la filière des déchets solides pour une gestion plus responsable, économique et respectueuse de l’environnement.

Objectifs pédagogiques :
- comprendre les enjeux et impacts de la gestion des déchets solides.
- connaître les principales techniques de traitement et de valorisation des déchets
- concevoir des projets de valorisation des déchets.
- appliquer les bonnes pratiques, innovations et outils de la gestion intégrée des déchets.
- Promouvoir la gestion participative et inclusive des déchets au sein de leurs communautés ou organisations.',
                'contenu_programme' => '- Panorama mondial et national de la gestion des déchets solides
- Typologies et caractéristiques des déchets
- Collecte, tri, stockage et transport des déchets
- Technologies de traitement : compostage, méthanisation, incinération, enfouissement.
- Transformation et valorisation déchets : notions d’économie circulaire
- Cadre réglementaire et financement
- Approches participatives et gestion communautaire',
                'duree' => '40 heures',
                'public_cible' => 'Correspondants énergie en entreprise, Responsables QSE, Ingénieurs et techniciens de l\'industrie et des bureaux d\'étude, Maîtres d\'ouvrage désirant promouvoir les énergies renouvelables.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M4',
                'type' => 'continue_a_la_carte',
                'titre' => 'ÉNERGIES RENOUVELABLES (EnR)',
                'resume' => 'Cette formation vise à développer aux seins des entreprises un esprit de promotion du développement durable en agissant sur l’efficacité et l’efficience énergétique.',
                'objectifs' => 'Inculquer aux participants le recours aux énergies renouvelables pour un développement durable.

Objectifs pédagogiques :
- réduire la facture énergétique et les émissions de CO2 d\'un établissement, d\'une installation ou d\'une activité par le recours aux énergies renouvelables.
- comprendre les conditions techniques, économiques et réglementaires
- de faire une Implantation d\'EnR en milieu industriel
- maîtriser les caractéristiques essentielles des principales technologies « énergies renouvelables »',
                'contenu_programme' => '- panorama des différentes formes d\'énergies renouvelables
- solaire, éolien, géothermie, valorisation de biomasse, etc.
- cadre réglementaire et conditions de marché
- réglementation régissant l\'implantation d\'installations d\'EnR
- quelles responsabilités pour quels acteurs
- focus sur les technologies les plus adaptées en milieu industriel',
                'duree' => '100 heures',
                'public_cible' => 'Producteurs agricoles, Associations etc.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 20,
                'places_max' => 40,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M5',
                'type' => 'continue_a_la_carte',
                'titre' => 'TECHNIQUES DE PRODUCTION DE COMPOSTE',
                'resume' => 'Permettre aux participants de produire du compost organique avec les ordures ménagères et les débris végétaux utile pour les plants au détriment des fertilisants chimiques.',
                'objectifs' => 'Outiller les participants de bonnes pratiques en matière de compostage en fosse ou en andin.

Objectifs pédagogiques :
- confectionner les différents types de fosse compostière ;
- appliquer la procédure de production du compost en andin avec les ordures ménagères ;
- appliquer la procédure de production du compost en andin avec les débris végétaux.',
                'contenu_programme' => '- Collecte et tris des matériaux de compostage
- Technique de confection des fosses compostières,
- Techniques de production du compost
- Suivi et récolte du composte',
                'duree' => '40 heures',
                'public_cible' => 'Agents du ministère en charge de l’environnement, Agents en charges d’environnement et de sécurité des mines.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulation pratique · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 20,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M6',
                'type' => 'continue_a_la_carte',
                'titre' => 'GESTION DES ANIMAUX A PROBLEMES',
                'resume' => 'Doter des participants de bonnes pratiques pour écarter les dangers liés aux animaux à problème (insectes, reptiles) tout en assurant leur maintien dans leur milieu naturel.',
                'objectifs' => 'Renforcer leurs capacités des participants dans le domaine de la gestion des animaux à problèmes (abeilles, serpents, crocodiles). Objectifs pédagogiques : A l’issu de la formation, les participants devront être capable de : - identifier les animaux à problèmes (serpents, abeilles, guêpes) ; - appliquer les mesures préventives de luttes contre les dangers à problèmes (serpents, abeilles, guêpes) ; - appliquer les techniques de captures et de relocalisation de ces animaux.',
                'contenu_programme' => '- les généralités sur les animaux à problèmes,
- les généralités sur les dangers liés aux animaux à problèmes,
- les techniques de captures et de translocation des animaux à problèmes.',
                'duree' => '50 heures',
                'public_cible' => 'Agents du ministère en charge de l’environnement, Consultants en gestion environnementales, Etudiants',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M7',
                'type' => 'continue_a_la_carte',
                'titre' => 'CARTOGRAPHIE, SIG ET TELEDETECTION',
                'resume' => 'Face aux enjeux croissants liés à la gestion des ressources naturelles, à l’aménagement du territoire et à la planification environnementale, la maîtrise des outils de cartographie, SIG et télédétection devient essentielle pour les acteurs publics et privés.',
                'objectifs' => 'Renforcer les capacités des agents pour leur permettre d’analyser, d’interpréter et de gérer efficacement des spatialités pour la prise de décisions éclairées.

Objectifs pédagogiques :
- acquérir les fondamentaux de la cartographie et des SIG.
- maîtriser les techniques d’acquisition, d’analyse et de traitement des données par télédétection.
- utiliser des logiciels SIG pour créer, analyser et visualiser des cartes thématiques.
- appliquer ces compétences dans des projets de gestion territoriale, environnementale ou d’aménagement.',
                'contenu_programme' => '- Introduction à la cartographie et à la topographie.
- Fondamentaux des SIG : architecture, composants et applications.
- Acquisition et traitement des données géospatiales.
- Techniques de télédétection : sources, capteurs et méthodes.
- Utilisation de logiciels SIG (ex : QGIS, ArcGIS).
- Analyse spatiale, géostatistique, modélisation et visualisation.',
                'duree' => '40 heures',
                'public_cible' => 'Promoteurs de projets',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M8',
                'type' => 'continue_a_la_carte',
                'titre' => 'ENTREPRENARIAT VERT ET INCLUSIF, EMPLOIS VERTS ET INCLUSIFS, DANS LE SECTEUR AGRO-SYLVO-PASTORAL',
                'resume' => 'Cette formation vise à encourager les entreprises à faire profit dans la résolution des problèmes environnementaux et socio-économiques.',
                'objectifs' => 'Il s’agit d’encourager les promoteurs à l’entreprenariat vert et inclusif dont l’un des impacts est la création d’emplois verts et inclusifs.

Objectifs pédagogiques :
- comprendre la responsabilité des entreprises dans les problèmes environnementaux et socio-économiques actuels, ainsi que les opportunités d’affaires et d’emploi qui y sont associées ;
- comprendre l’entreprenariat vert inclusif et l’emploi vert inclusif ;
- comprendre le processus de création d’une entreprise verte inclusive dans le secteur agro-sylvo-pastoral ;
- comprendre la finance verte ;
- identifier les sources de financements verts',
                'contenu_programme' => '- les entreprises face aux problèmes environnementaux et socio-économiques
- notions d’entreprenariat vert et inclusif et d’emploi vert et inclusif
- création d’une entreprise verte et inclusive
- concept de finance verte
- opportunités de financement vert
- critères pour l\'accès aux financements.',
                'duree' => '60 heures',
                'public_cible' => 'Promoteur de ferme agrosylvopastoral, producteurs individuels, associations, groupements…',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 50,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M9',
                'type' => 'continue_a_la_carte',
                'titre' => 'PRODUCTION ET ENTRETIEN DES PLANTS',
                'resume' => 'Cette formation vise à appuyer les producteurs à produire et à entretenir eux même leurs plants.',
                'objectifs' => 'Il s’agit d’accompagner les producteurs, les associations à la maîtrise de la production, la plantation et l’entretien des plants.

Objectifs pédagogiques :
- installer une pépinière ;
- assimiler les techniques de production des plants ;
- collecter et traiter les semences.',
                'contenu_programme' => '- Mélange de terres en pépinière
- Traitement de la terre de la pépinière
- Remplissage/dimension des pots
- Prétraitement des semences
- Semis des graines
- Arrosage des plants dans la pépinière
- Repiquage des plants
- Entretien du matériel de reproduction en pépinière
- Reproduction végétative
- Dimension et qualité du matériel de plantation
- Préparation des plants pour le site de plantation
- Transport des plants sur le site de plantation
- Organisation de la plantation et entretien des plants',
                'duree' => '40 heures',
                'public_cible' => 'Promoteur de ferme agrosylvopastoral, producteurs individuels, associations, groupements…',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M10',
                'type' => 'continue_a_la_carte',
                'titre' => 'RECONNAISSANCE ET TRAITEMENT DES PATHOLOGIES DES PLANTES FORESTIÈRES',
                'resume' => 'Aux termes de la formation et face à la dégradation accélérée des ressources naturelles, les apprenants détiennent des solutions en décrivant les différentes pathologies qui affectent les végétaux afin de promouvoir la diversité biologique',
                'objectifs' => 'Il s’agit d’accompagner les producteurs, les associations à la maîtrise de la production, la plantation et l’entretien des plants. Objec t ifs pédagogiques : A la fin de la séance, les participants seront capables de : - décrire les pathologies des espèces forestières; - proposer un traitement contre ces pathologies.',
                'contenu_programme' => '- Généralités sur les pathologies forestières : classification, pathogènes, symptômes
- Epidémiologie des maladies : développement et de propagation des pathologies.
- Réglementation en matière de santé des plantes.
- Techniques d’identification des maladies : reconnaissance par symptômes et agents pathogènes.
- Techniques de diagnostic : méthodes in situ et en laboratoire.
- Gestion et traitement : stratégies de contrôle, incluant les traitements phytosanitaires et les pratiques de gestion intégrée',
                'duree' => '40 heures',
                'public_cible' => 'Collectivité, promoteurs privés, toutes personnes physiques ou morale désireuse d’aménager son espace forestière ou sa plantation.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M11',
                'type' => 'continue_a_la_carte',
                'titre' => 'AMÉNAGEMENT DES ESPACES FORESTIERS',
                'resume' => 'Au Burkina Faso où plus de 80% de la population utilise la ressource ligneuse comme énergie de chauffe, les réflexions ont été axées sur des stratégies d’exploitation durable des ressources naturelles. Ainsi l’aménagement forestier apparaît comme un outil d’exploitation durable des forêts.',
                'objectifs' => 'Il s’agit d’accompagner les acteurs à l’aménagement et à l’exploitation rationnelle des espaces forestiers.

Objectifs pédagogiques :
- élaborer un plan d’aménagement d’un espace forestier.
- suivre la mise en œuvre des PAF
- concevoir des initiatives de valorisation durables des ressources forestières
- élaborer des projets d’aménagement forestiers
- contribuer à l’élaboration des textes régissant la gestion des ressources forestières.',
                'contenu_programme' => '- principes directeurs de l’aménagement forestier au Burkina Faso
- méthodologie d’aménagement ou “le modèle d’aménagement”
- mécanisme de financement de la gestion forestière
- initiatives de valorisation durables des ressources forestières',
                'duree' => '50 heures',
                'public_cible' => 'Promoteurs de sites miniers, responsable environnement, Consultants, formateurs, responsables communaux, OSC',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 25,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M12',
                'type' => 'continue_a_la_carte',
                'titre' => 'MECANISMES DE REHABILITATION DES SITES MINIERS',
                'resume' => 'Le secteur minier, source de croissance économique, entraîne des impacts environnementaux importants. La réhabilitation des sites est essentielle pour réduire ces impacts, restaurer l’environnement et promouvoir une gestion durable.',
                'objectifs' => 'Il s’agit de renforcer les compétences techniques et réglementaires des acteurs en matière de mécanismes, stratégies et bonnes pratiques pour la réhabilitation des sites miniers.

Objectifs pédagogiques :
- Identifier les axes d’interventions de la réhabilitation progressive,
- Choisir judicieusement les options d’une réhabilitation efficiente applicable à leur site d’exploitation.',
                'contenu_programme' => '- Introduction à la réhabilitation des sites miniers
- Bases techniques de la réhabilitation
- Mécanismes de réhabilitation
- Approches et méthodes
- Aspects réglementaires et socio-économiques
- Gestion et suivi post-réhabilitation
- Outils et bonnes pratiques',
                'duree' => '24 heures',
                'public_cible' => 'Chefs de service et agents de la DGEF',
                'techniques' => 'Exposé illustré · Travaux dirigés · Sorties terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M13',
                'type' => 'continue_a_la_carte',
                'titre' => 'GESTION DURABLE DES TERRES (GDT)',
                'resume' => 'Dans tous les grands systèmes d’utilisations de terres en Afrique subsaharienne, cultures, pâturages, forêts et terres mixtes, la GDT met l’accent sur l’amélioration de la productivité agricole, des moyens d’existence et des écosystèmes (FAO, 2011). Les agents devraient maitriser les différentes pratiques afin d’appuyer les producteurs à mettre en œuvre les différentes mesures de gestions durables des terres.',
                'objectifs' => 'L’objectif global est d’améliorer les capacités des agents du ministère sur la GDT.

Objectifs pédagogiques :
- mettre en œuvre les mesures agronomiques de GDT
- mettre en œuvre les mesures forestières et agroforestières de GDT
- mettre en œuvre les mesures structurelles de GDT',
                'contenu_programme' => '- bonnes pratiques de mesures agronomiques de GDT
- bonnes pratiques de mesures forestières et agroforestières de GDT
- bonnes pratiques des mesures structurelles de GDT
- Pratique des mesures de gestion',
                'duree' => '30 heures',
                'public_cible' => 'Chefs de service et agents de la DGPE Industriels PME, PMI',
                'techniques' => 'Exposé illustré · Travaux dirigés · Sorties terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M14',
                'type' => 'continue_a_la_carte',
                'titre' => 'GESTION ET PRÉVENTION DES RISQUES ENVIRONNEMENTAUX',
                'resume' => 'Il s’agira pour les agents de cerner que les « risques liés à l’environnement » sont de double nature. Il s’agit : - des dommages générés par l’entreprise et impactant l’environnement (eau, air, sol…) dans le cadre de ses activités. - des risques subis tels que ceux d’origine naturelle : inondation, mouvement de terrain, tempête, foudre, sécheresse. Ou ceux d’origine industrielle : accidents extérieurs liés à une installation ou une activité dangereuse à proximité (rupture de digue, installations industrielles ou nucléaires, grands barrages, transport de matières dangereuses.)',
                'objectifs' => 'L’objectif global est d’améliorer les capacités des agents du ministère.

Objectifs pédagogiques :
- identifier les risques environnementaux
- évaluer les risques environnementaux
- maîtriser les risques environnementaux
- contrôler les risques environnementaux',
                'contenu_programme' => '- identification des risques environnementaux
- évaluation des risques environnementaux
- maîtrise des risques environnementaux
- contrôle des risques environnementaux',
                'duree' => '24 heures',
                'public_cible' => 'Responsables et agents publics/communaux Managers et dirigeants d’entreprises. Étudiants et universitaires. Acteurs d’ONG et de la société civile. Consultants et experts.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Sorties terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M15',
                'type' => 'continue_a_la_carte',
                'titre' => 'FISCALITÉ ENVIRONNEMENTALE',
                'resume' => 'Face aux enjeux croissants liés à la protection de l’environnement, la fiscalité environnementale s’impose comme un outil stratégique pour encourager les comportements responsables et financer la transition écologique. Il est donc essentiel de renforcer les compétences des acteurs publics, privés, et de la société civile dans ce domaine',
                'objectifs' => 'Renforcer les capacités des participants sur les mécanismes de la fiscalité environnementale, ses instruments, ses enjeux, et son rôle dans la transition vers un développement durable.

Objectifs pédagogiques :
- comprendre les concepts clés
- identifier les différents instruments fiscaux utilisés
- élaborer des politiques fiscales adaptées au contexte local.',
                'contenu_programme' => '- concepts fondamentaux de la fiscalité environnementale.
- instruments et mécanismes fiscaux (taxes, redevances, crédits carbone, etc.).
- cadre juridique et réglementaire.
- analyse d’impact économique et environnemental.
- limites et opportunité de la fiscalité environnementale au Burkina Faso
- élaboration et mise en œuvre de politiques fiscales.',
                'duree' => '40 heures',
                'public_cible' => 'Enseignants, éducateurs, formateurs, Responsables d’ONG et d’associations. Agents des administrations publiques. Leaders communautaires Étudiants',
                'techniques' => 'Exposé illustré · Travaux dirigés · Visite terrain · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 50,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M16',
                'type' => 'continue_a_la_carte',
                'titre' => 'EDUCATION ENVIRONNEMENTALE (EE)',
                'resume' => 'Face aux défis environnementaux actuels, l’éducation environnementale apparaît comme un levier essentiel pour sensibiliser, informer et mobiliser toutes les sphères de la société. Renforcer les capacités des acteurs éducatifs et communautaires est crucial pour promouvoir un comportement responsable et une gestion durable des ressources naturelles.',
                'objectifs' => 'Renforcer les compétences des participants en matière d’EE afin de favoriser une meilleure sensibilisation à la culture de l’écocitoyenneté et une approche pédagogique innovante pour encourager la protection de l’environnement.

Objectifs pédagogiques :
- comprendre les principes et enjeux de l’EE.
- développer des compétences pour intégrer l’EE dans les programmes éducatifs et communautaires.
- concevoir et mettre en œuvre des activités éducatives adaptées aux différents publics.
- favoriser la sensibilisation à la gestion durable des ressources naturelles.
- promouvoir une approche participative et communautaire dans l’EE',
                'contenu_programme' => '- Concepts clés et principes de l’EE
- Enjeux et défis environnementaux locaux et globaux.
- Techniques et méthodes d’animation et d’éducation participative.
- Conception de programmes et d’activités éducatives.
- Outils pédagogiques et technologiques.
- Etudes de cas et retours d’expériences.
- Stratégies de mobilisation communautaire.',
                'duree' => '50 heures',
                'public_cible' => 'Responsable Hygiène-Sécurité-Environnement',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M17',
                'type' => 'continue_a_la_carte',
                'titre' => 'BILAN CARBONE',
                'resume' => 'Il est primordial pour une société de poser des actions pour la réduction des GES. C’est pourquoi la connaissance de son mode de fonctionnement et des flux d’émissions un facteur important dans l’élaboration des stratégies de réduction. Cette formation devrait permettre de mettre en œuvre cette stratégie.',
                'objectifs' => 'Contribuer à l’amélioration des performances environnementales et énergétiques par la réalisation d’un état des lieux de l’empreinte carbone de l’entreprise.

Objectifs pédagogiques :
- comment identifier les postes d’émission du carbone de l’entreprise.
- comment évaluer les émissions de carbone par poste de fonctionnement de la société.
- comment établir une hiérarchisation des actions de réduction de l’émission de carbone de la société.
- comment proposer une esquisse de plan de réduction des émissions de carbone de la société.',
                'contenu_programme' => '- description détaillée des pratiques actuelles au sein d’une société en relation avec les milieux récepteurs.
- identification et caractérisation des aspects environnementaux et énergétiques d’une société
- évaluation des émissions de carbone par poste de fonctionnement d’une société.
- établissement d’une hiérarchisation des actions de réduction de l’émission de carbone d’une société.
- proposition d’esquisse de plan de réduction des émissions de carbone d’une société.',
                'duree' => '60 heures',
                'public_cible' => 'Chercheurs, consultants, étudiants, techniciens, responsable d’ONG, de SCOOP de gestion forestière, promoteurs privés, toutes personne physique ou morale.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M18',
                'type' => 'continue_a_la_carte',
                'titre' => 'INVENTAIRES FORESTIERS',
                'resume' => 'L’inventaire constitue un outil essentiel pour suivi écologique une gestion durable des ressources forestières, permettant d’évaluer les stocks, de suivre leur évolution et de prendre des décisions éclairées pour la conservation et l’aménagement des forêts. Cette formation permettra de développer les connaissances et techniques nécessaires pour conduire efficacement ces évaluations, en conformité avec les normes et meilleures pratiques internationales.',
                'objectifs' => 'Il s’agit de permettre aux gestionnaires forestiers de maîtriser les méthodes et outils d’inventaire forestier.

Objectifs pédagogiques :
- Planifier une opération d’inventaire en définissant les objectifs, la zone d’étude et le protocole.
- Réaliser les levés et mesures forestières (diamètres, hauteurs, etc.) sur le terrain en respectant les normes.
- Utiliser efficacement les outils technologiques (GPS, logiciels de collecte de données) pour recueillir et gérer les informations.
- Analyser et interpréter les données recueillies pour élaborer des indicateurs clés de gestion.
- Rédiger un rapport d’inventaire clair, précis et exploitable.
- Présenter les résultats de l’inventaire à différentes parties prenantes pour orienter la prise de décision en gestion durable.',
                'contenu_programme' => '- Introduction à l’inventaire forestier : enjeux, cadre réglementaire, objectifs.
- Planification d’un projet d’inventaire forestier
- Techniques de terrain : mesures forestières (diamètres, hauteurs), utilisation du matériel.
- Outils technologiques : GPS, logiciels de collecte et gestion des données.
- Analyse, traitement et interprétation des données
- Rédaction du rapport',
                'duree' => '40 heures',
                'public_cible' => 'Agents des forces de sécurité (Eaux et Forêts, Police Municipale, …), Agents du secteur judiciaire, Environnementalistes, Acteurs de la société civile, Consultants spécialisés.',
                'techniques' => 'Exposé illustré · Travaux dirigés · Simulations pratiques · Formative · Sommative',
                'cout_indicatif' => null,
                'places_min' => 10,
                'places_max' => 30,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
            [
                'code_module' => 'R2M19',
                'type' => 'continue_a_la_carte',
                'titre' => 'CRIMINALITE ENVIRONNEMENTALE',
                'resume' => 'La criminalité environnementale, en augmentation, menace les écosystèmes, la santé et la sécurité. La lutte nécessite des compétences spécifiques en détection, enquête et poursuite. Renforcer les capacités des acteurs est essentiel pour améliorer la réponse judiciaire et administrative.',
                'objectifs' => 'Il s’agit de renforcer les compétences des participants sur les formes, les impacts et les mécanismes de lutte contre la criminalité environnementale, en conformité avec la législation nationale et internationale.

Objectifs pédagogiques :
- comprendre la nature et l’étendue de la criminalité environnementale.
- connaître le cadre juridique national et international applicable.
- identifier les principales infractions environnementales et leurs modes opératoires.
- maîtriser les techniques d’enquête, de collecte de preuves et de poursuite.
- promouvoir la coopération interinstitutionnelle pour lutter efficacement contre ces crimes.
- développer des compétences pour élaborer des stratégies de prévention et d’intervention.',
                'contenu_programme' => '- Définition et typologie de la criminalité environnementale.
- Cadre juridique national et international (conventions, protocoles, lois nationales).
- Modes opératoires et circuits de criminalité environnementale.
- Techniques d’enquête, collecte de preuves et traçabilité.
- Outils de coopération et de coordination interinstitutionnelle.
- Stratégies de prévention et de sensibilisation.',
                'duree' => null,
                'public_cible' => null,
                'techniques' => null,
                'cout_indicatif' => null,
                'places_min' => null,
                'places_max' => null,
                'periode_indicative' => null,
                'statut' => 'ouverte',
            ],
        ];

        foreach ($modules as $data) {
            $categorieId = $data['type'] === 'continue_programmee' ? $categorieProgrammeeId : $categorieALaCarteId;

            Formation::updateOrCreate(
                ['code_module' => $data['code_module']],
                array_merge($data, [
                    'slug' => Str::slug($data['titre']),
                    'categorie_id' => $categorieId,
                    'created_by' => $userId,
                ])
            );
        }

        $this->command->info(count($modules) . ' formations du catalogue ENEF importées/mises à jour.');
    }
}