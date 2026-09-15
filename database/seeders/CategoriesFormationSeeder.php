<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesFormationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Formation programmée',
            'Formation à la carte',
        ];

        foreach ($categories as $nom) {
            DB::table('categories_formation')->insert([
                'id' => (string) Str::uuid(),
                'nom' => $nom,
                'slug' => Str::slug($nom),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}