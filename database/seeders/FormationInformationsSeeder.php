<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Informations complémentaires du catalogue ENEF : frais annexes,
 * modalités de paiement des classes intermédiaires/terminales,
 * composition du dossier de candidature.
 *
 * Relançable sans doublons : la table est vidée puis repeuplée à
 * chaque exécution (données de référence, pas de relation entrante).
 */
class FormationInformationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('formation_informations')->delete();

        $lignes = [
            // ───────────── Frais annexes ─────────────
            ['categorie' => 'frais', 'libelle' => 'Dépôt de dossier', 'valeur' => '3 000 F CFA (non remboursable)', 'ordre' => 1],
            ['categorie' => 'frais', 'libelle' => 'Alimentation', 'valeur' => '10 000 F CFA / mois (obligatoire pour les internes)', 'ordre' => 2],
            ['categorie' => 'frais', 'libelle' => 'Assurance santé', 'valeur' => '5 000 F CFA / élève / an (obligatoire)', 'ordre' => 3],

            // ───────────── Paiement — classes intermédiaires ─────────────
            ['categorie' => 'paiement_intermediaire', 'libelle' => 'À la rentrée', 'valeur' => '50% du montant + 5 000 F CFA de caution', 'ordre' => 1],
            ['categorie' => 'paiement_intermediaire', 'libelle' => 'Fin décembre au plus tard', 'valeur' => '25% du montant', 'ordre' => 2],
            ['categorie' => 'paiement_intermediaire', 'libelle' => 'Fin février au plus tard', 'valeur' => '25% du montant', 'ordre' => 3],

            // ───────────── Paiement — classes terminales ─────────────
            ['categorie' => 'paiement_terminale', 'libelle' => 'À la rentrée', 'valeur' => '50% du montant + 5 000 F CFA de caution', 'ordre' => 1],
            ['categorie' => 'paiement_terminale', 'libelle' => 'Fin décembre au plus tard', 'valeur' => '50% du montant', 'ordre' => 2],

            // ───────────── Composition du dossier ─────────────
            ['categorie' => 'dossier', 'libelle' => 'Une demande timbrée adressée au Directeur Général de l’ENEF', 'valeur' => null, 'ordre' => 1],
            ['categorie' => 'dossier', 'libelle' => 'Un extrait de naissance', 'valeur' => null, 'ordre' => 2],
            ['categorie' => 'dossier', 'libelle' => 'Les diplômes légalisés', 'valeur' => null, 'ordre' => 3],
            ['categorie' => 'dossier', 'libelle' => 'Un curriculum vitae', 'valeur' => null, 'ordre' => 4],
            ['categorie' => 'dossier', 'libelle' => 'Une photocopie légalisée de la carte d’identité', 'valeur' => null, 'ordre' => 5],
            ['categorie' => 'dossier', 'libelle' => 'Quatre (04) photos d’identité', 'valeur' => null, 'ordre' => 6],
        ];

        $now = now();

        foreach ($lignes as &$ligne) {
            $ligne['id'] = (string) Str::uuid();
            $ligne['created_at'] = $now;
            $ligne['updated_at'] = $now;
        }
        unset($ligne);

        DB::table('formation_informations')->insert($lignes);

        $this->command->info(count($lignes) . ' informations complémentaires importées.');
    }
}