<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Coordonnées GPS (navigateur) des visites : latitude, longitude et
     * précision en mètres, fournies par le visiteur via l'API Geolocation
     * (avec son consentement). Complètent le lieu approximatif déduit de
     * l'adresse IP (ville / pays), sans le remplacer.
     */
    public function up(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('ville');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->decimal('precision_m', 10, 2)->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'precision_m']);
        });
    }
};