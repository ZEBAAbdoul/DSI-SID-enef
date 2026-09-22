<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ParametresSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un utilisateur existant
        $user = DB::table('users')->first();

        DB::table('parametres_site')->insert([
            'id' => (string) Str::uuid(),
            'nom_site' => 'ENEF - École Nationale des Eaux et Forêts',
            'slogan' => 'Former pour protéger, agir pour préserver.',
            'logo_url' => '/storage/logos/enef-logo.jpg',
            'favicon_url' => '/storage/favicons/enef-favicon.ico',
            'mot_dg_titre' => 'Mot du Directeur Général',
            'mot_dg_contenu' => 'Depuis 1953, l’Ecole Nationale des Eaux et Forêts (ENEF) œuvre à la formation de professionnels qualifiés au service de la gestion durable des ressources naturelles et de la protection de l’environnement au Burkina Faso.
            Face aux défis croissants liés aux changements climatiques, à la préservation de la biodiversité et à la gestion durable des ressources naturelles, l’ENEF entend consolider son rôle d’institution de référence dans la formation, le perfectionnement, la recherche et l’expertise dans les domaines des Ressources Naturelles et de l’Environnement.
            Notre ambition est de faire de l’ENEF une école moderne, ouverte sur le monde professionnel, engagée dans l’innovation et capable d’anticiper les besoins en compétences de notre pays et de la sous-région. La diversification de notre offre de formation, le développement de nos unités pédagogiques et de production, le renforcement des partenariats et la valorisation de notre expertise constituent des leviers essentiels de cette dynamique.
            A travers ce site web, nous souhaitons renforcer notre proximité avec nos stagiaires, nos partenaires et l’ensemble de nos publics, tout en offrant une meilleure visibilité à nos formations, nos activités, nos réalisations et nos expertises.
            Ensemble, faisons de l’excellence, de l’innovation et de l’engagement les moteurs d’une gestion durable de notre environnement et de nos ressources naturelles.
            ',
            'mot_dg_photo_url' => '/storage/dg/dg.jpeg',
            'mot_dg_nom' => 'COL Fiédi HAKIEKOU',
            'adresse' => '01 BP 1105, Dindéresso — Bobo-Dioulasso, Burkina Faso',
            'telephone' => '(+226) 20 98 06 89',
            'email_contact' => 'infos@enef.gov.bf',
            'annee_creation' => 1953,
            'personne_forme' => 10000,
            'facebook_url' => 'https://web.facebook.com/enef2021',
            'linkedin_url' => 'https://linkedin.com/school/enef-sn',
            'meta_description' => 'Depuis 1953, l\'ENEF forme les cadres et techniciens qui protègent les ressources naturelles du Burkina Faso — formation initiale, formation continue et appui-conseil aux structures publiques et privées.',
            'updated_by' => $user ? $user->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
