<?php

namespace Database\Seeders;

use App\Models\TypePiece;
use Illuminate\Database\Seeder;

class TypePieceSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code' => 'cni',                'libelle' => "Carte d'identité",      'obligatoire' => true,  'ordre' => 1],
            ['code' => 'acte_naissance',      'libelle' => 'Acte de naissance',      'obligatoire' => true,  'ordre' => 2],
            ['code' => 'diplome',             'libelle' => 'Diplôme',                'obligatoire' => true,  'ordre' => 3],
            // ['code' => 'releve_notes',        'libelle' => 'Relevé de notes',        'obligatoire' => true,  'ordre' => 4],
            // ['code' => 'certificat_medical',  'libelle' => 'Certificat médical',     'obligatoire' => true,  'ordre' => 5],
            ['code' => 'photo_identite',      'libelle' => "Photo d'identité",       'obligatoire' => true,  'ordre' => 6],
            // ['code' => 'cv',                  'libelle' => 'CV',                     'obligatoire' => true,  'ordre' => 7],
            ['code' => 'lettre_motivation',   'libelle' => 'Lettre de motivation',   'obligatoire' => true,  'ordre' => 8],
            // ['code' => 'autre',               'libelle' => 'Document complémentaire','obligatoire' => false, 'ordre' => 9],
        ];

        foreach ($types as $type) {
            TypePiece::updateOrCreate(['code' => $type['code']], $type);
        }
    }
}