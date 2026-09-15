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
            'slogan' => 'Former les gardiens des eaux, des forêts et de l\'environnement',
            'logo_url' => '/storage/logos/enef-logo.jpg',
            'favicon_url' => '/storage/favicons/enef-favicon.ico',
            'mot_dg_titre' => 'Mot du Directeur Général',
            'mot_dg_contenu' => 'Former des cadres compétents, intègres et engagés pour la préservation durable de nos eaux, de nos forêts et de notre environnement, c\'est la mission que l\'ENEF porte depuis plus de 70 ans.',
            'mot_dg_photo_url' => '/storage/dg/enef-dg.jpg',
            'mot_dg_nom' => 'Col. Fiédi HAKIEKOU',
            'adresse' => '01 BP 1105, Dindéresso — Bobo-Dioulasso, Burkina Faso',
            'telephone' => '(+226) 20 98 06 89',
            'email_contact' => 'infos@enef.gov.bf',
            'annee_creation' => 1953,
            'personne_forme' => 1500,
            'facebook_url' => 'https://web.facebook.com/enef2021',
            'linkedin_url' => 'https://linkedin.com/school/enef-sn',
            'meta_description' => 'Depuis 1953, l\'ENEF forme les cadres et techniciens qui protègent les ressources naturelles du Burkina Faso — formation initiale, formation continue et appui-conseil aux structures publiques et privées.',
            'updated_by' => $user ? $user->id : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}