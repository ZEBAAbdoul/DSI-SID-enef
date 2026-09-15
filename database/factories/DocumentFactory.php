<?php

namespace Database\Factories;

use App\Models\CategorieDocument;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        $type = fake()->randomElement([
            'rapport',
            'brochure',
            'texte_reglementaire',
            'support_pedagogique',
        ]);

        $format = fake()->randomElement(['pdf', 'docx', 'xlsx']);

        $titresParType = [
            'rapport' => [
                'Rapport annuel', 'Rapport d\'activités', 'Rapport d\'évaluation',
                'Rapport de mission', 'Rapport financier',
            ],
            'brochure' => [
                'Brochure de présentation', 'Brochure des filières', 'Brochure institutionnelle',
                'Guide du candidat',
            ],
            'texte_reglementaire' => [
                'Décret d\'organisation', 'Arrêté de nomination', 'Statut du personnel',
                'Règlement intérieur',
            ],
            'support_pedagogique' => [
                'Support de cours', 'Manuel de formation', 'Fiche pédagogique',
                'Guide pratique',
            ],
        ];

        $titre = fake()->randomElement($titresParType[$type])
            . ' ' . fake()->year();

        return [
            'categorie_id' => CategorieDocument::inRandomOrder()->value('id'),
            'titre' => $titre,
            'description' => fake()->paragraph(),
            'type' => $type,
            'fichier_url' => 'documents/' . fake()->uuid() . '.' . $format,
            'format_fichier' => $format,
            'taille_fichier_ko' => fake()->numberBetween(80, 5000),
            'acces' => fake()->randomElement(['public', 'public', 'public', 'restreint']), // 75% public
            'version' => fake()->randomElement(['1.0', '1.1', '2.0', null]),
            'nombre_telechargements' => fake()->numberBetween(0, 800),
            'publie_le' => fake()->dateTimeBetween('-5 years', 'now'),
            'publie_par' => User::inRandomOrder()->value('id'),
        ];
    }

    public function public(): static
    {
        return $this->state(fn () => ['acces' => 'public']);
    }

    public function restreint(): static
    {
        return $this->state(fn () => ['acces' => 'restreint']);
    }
}