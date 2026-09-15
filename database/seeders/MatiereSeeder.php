<?php

namespace Database\Seeders;

use App\Models\Matiere;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    public function run(): void
    {
        $matieres = [
            ['nom' => 'Écologie forestière', 'code' => 'ECO-FOR', 'coefficient' => 3, 'volume_horaire' => 60],
            ['nom' => 'SIG appliqué', 'code' => 'SIG-APP', 'coefficient' => 2, 'volume_horaire' => 45],
            ['nom' => 'Droit de l\'environnement', 'code' => 'DRT-ENV', 'coefficient' => 2, 'volume_horaire' => 30],
            ['nom' => 'Gestion de projet', 'code' => 'GST-PRJ', 'coefficient' => 1.5, 'volume_horaire' => 30],
            ['nom' => 'Sylviculture', 'code' => 'SYLV', 'coefficient' => 3, 'volume_horaire' => 50],
            ['nom' => 'Inventaire forestier', 'code' => 'INV-FOR', 'coefficient' => 2, 'volume_horaire' => 40],
        ];

        foreach ($matieres as $matiere) {
            Matiere::updateOrCreate(['code' => $matiere['code']], $matiere);
        }
    }
}