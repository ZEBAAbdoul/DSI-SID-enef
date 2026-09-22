<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Catégories de formation ENEF.
 *
 * Relançable sans doublons : une catégorie déjà présente (même nom ou même slug)
 * est ignorée, donc on peut relancer ce seeder pour n'ajouter que
 * "Formation initiale" sans toucher aux ids des catégories existantes.
 */
class CategoriesFormationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Formation initiale',
            'Formation programmée',
            'Formation à la carte',
        ];

        foreach ($categories as $nom) {
            $slug = Str::slug($nom);

            $existe = DB::table('categories_formation')
                ->where('nom', $nom)
                ->orWhere('slug', $slug)
                ->exists();

            if ($existe) {
                continue;
            }

            DB::table('categories_formation')->insert([
                'id' => (string) Str::uuid(),
                'nom' => $nom,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}