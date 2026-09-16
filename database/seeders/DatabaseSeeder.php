<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SessionFormation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ParametresSiteSeeder::class);
        $this->call(CategoriesFormationSeeder::class);
        $this->call(FilieresSeeder::class);
        $this->call(FormationsSeeder::class);
        $this->call(SessionsFormationSeeder::class);
        $this->call(TemoignagesSeeder::class);
        $this->call(ActualitesSeeder::class);
        $this->call(CategorieDocumentSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(PartenaireSeeder::class);
        $this->call(MatiereSeeder::class);
        $this->call(EnseignantSeeder::class);
        // $this->call(NoteSeeder::class);
        $this->call(TypePieceSeeder::class);
    }
}
