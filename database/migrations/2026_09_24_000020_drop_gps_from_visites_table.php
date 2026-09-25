<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Retrait de la géolocalisation GPS navigateur (colonnes ajoutées par
 * 2026_09_24_000010_add_gps_to_visites_table.php) : la localisation des
 * visiteurs repose désormais uniquement sur l'adresse IP (ville/pays).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'precision_m']);
        });
    }

    public function down(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('precision_m')->nullable();
        });
    }
};