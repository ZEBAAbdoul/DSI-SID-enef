<?php

namespace Database\Seeders;

use App\Models\CategorieDocument;
use Illuminate\Database\Seeder;

class CategorieDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $rapports = CategorieDocument::create(['nom' => 'Rapports']);
        $brochures = CategorieDocument::create(['nom' => 'Brochures']);
        $textes = CategorieDocument::create(['nom' => 'Textes réglementaires']);
        $pedagogie = CategorieDocument::create(['nom' => 'Supports pédagogiques']);

        CategorieDocument::create(['nom' => 'Rapports annuels', 'parent_id' => $rapports->id]);
        CategorieDocument::create(['nom' => 'Rapports d\'activités', 'parent_id' => $rapports->id]);
        CategorieDocument::create(['nom' => 'Rapports de mission', 'parent_id' => $rapports->id]);
        CategorieDocument::create(['nom' => 'Décrets', 'parent_id' => $textes->id]);
        CategorieDocument::create(['nom' => 'Arrêtés', 'parent_id' => $textes->id]);
        CategorieDocument::create(['nom' => 'Statuts et règlements', 'parent_id' => $textes->id]);
        CategorieDocument::create(['nom' => 'Guides pratiques', 'parent_id' => $pedagogie->id]);
        CategorieDocument::create(['nom' => 'Manuels de cours', 'parent_id' => $pedagogie->id]);
    }
}