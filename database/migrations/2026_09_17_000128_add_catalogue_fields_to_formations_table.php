<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ajoute UNIQUEMENT les colonnes qui n'existent pas déjà dans `formations`.
 * La table possède déjà : resume, objectifs, contenu_programme, duree,
 * public_cible, cout_indicatif, statut, image_url, mots_cles — réutilisées
 * telles quelles par le seeder du catalogue, aucune colonne JSON requise.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            if (!Schema::hasColumn('formations', 'code_module')) {
                $table->string('code_module', 20)->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('formations', 'techniques')) {
                $table->string('techniques', 255)->nullable()->after('public_cible');
            }
            if (!Schema::hasColumn('formations', 'places_min')) {
                $table->unsignedInteger('places_min')->nullable()->after('cout_indicatif');
            }
            if (!Schema::hasColumn('formations', 'places_max')) {
                $table->unsignedInteger('places_max')->nullable()->after('places_min');
            }
            if (!Schema::hasColumn('formations', 'periode_indicative')) {
                $table->string('periode_indicative', 100)->nullable()->after('places_max');
            }
        });
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn([
                'code_module',
                'techniques',
                'places_min',
                'places_max',
                'periode_indicative',
            ]);
        });
    }
};