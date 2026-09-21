<?php

namespace Database\Seeders;

use App\Models\CategorieDocument;
use Illuminate\Database\Seeder;

class CategorieDocumentSeeder extends Seeder
{
    public function run(): void
    {
        

        CategorieDocument::create(['nom' => 'Rapports annuels']);
        CategorieDocument::create(['nom' => 'Rapports d\'activités']);
        CategorieDocument::create(['nom' => 'Rapports de mission']);
        CategorieDocument::create(['nom' => 'Décrets']);
        CategorieDocument::create(['nom' => 'Arrêtés']);
        CategorieDocument::create(['nom' => 'Statuts et règlements']);
        CategorieDocument::create(['nom' => 'Guides pratiques']);
        CategorieDocument::create(['nom' => 'Manuels de cours']);
    }
}