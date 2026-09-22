<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute la configuration des liens utiles (JSON : [{titre, url}]).
     */
    public function up(): void
    {
        Schema::table('parametres_site', function (Blueprint $table) {
            $table->json('liens_utiles')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('parametres_site', function (Blueprint $table) {
            $table->dropColumn('liens_utiles');
        });
    }
};