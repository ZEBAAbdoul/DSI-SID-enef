<?php

namespace Database\Seeders;

use App\Models\Partenaire;
use Illuminate\Database\Seeder;

class PartenaireSeeder extends Seeder
{
    public function run(): void
    {
        $partenaires = [
            [
                'nom' => 'PONASI',
                'type' => 'financier',
                'logo_url' => 'partenaires/ponasi.WEBP',
                'site_web' => null,
                'description' => 'Programme national d\'appui au secteur de l\'irrigation, partenaire financier de plusieurs formations et missions d\'appui-conseil.',
                'ordre_affichage' => 1,
            ],
            [
                'nom' => 'CORDAID',
                'type' => 'financier',
                'logo_url' => 'partenaires/cordaid.webp',
                'site_web' => 'https://www.cordaid.org',
                'description' => 'Organisation internationale de développement, partenaire financier et technique de l\'ENEF.',
                'ordre_affichage' => 2,
            ],
            [
                'nom' => 'Collectivités territoriales',
                'type' => 'collectivite',
                'logo_url' => 'partenaires/collectivites.png',
                'site_web' => null,
                'description' => 'Communes et régions bénéficiaires des prestations d\'appui-conseil et d\'aménagement de l\'ENEF.',
                'ordre_affichage' => 3,
            ],
            [
                'nom' => 'Secteur minier',
                'type' => 'technique',
                'logo_url' => 'partenaires/secteur-minier.png',
                'site_web' => null,
                'description' => 'Entreprises minières partenaires pour les missions de réhabilitation environnementale.',
                'ordre_affichage' => 4,
            ],
            [
                'nom' => 'MSECU',
                'type' => 'institutionnel',
                'logo_url' => 'partenaires/msecu.png',
                'site_web' => null,
                'description' => 'Ministère partenaire institutionnel de l\'ENEF.',
                'ordre_affichage' => 5,
            ],
            [
                'nom' => 'DGEF',
                'type' => 'institutionnel',
                'logo_url' => 'partenaires/dgef.webp',
                'site_web' => null,
                'description' => 'Direction Générale des Eaux et Forêts, structure de tutelle technique de l\'ENEF.',
                'ordre_affichage' => 6,
            ],
        ];

        foreach ($partenaires as $partenaire) {
            Partenaire::updateOrCreate(
                ['nom' => $partenaire['nom']],
                [...$partenaire, 'actif' => true]
            );
        }
    }
}