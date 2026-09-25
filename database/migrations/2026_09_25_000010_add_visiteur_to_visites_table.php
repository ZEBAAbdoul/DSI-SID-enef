<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Identifiant stable du visiteur : le cookie enef_visiteur posé par le site
     * public survit à la régénération de session (connexion / déconnexion de
     * l'administration), ce qui évite de compter deux fois le même visiteur le
     * même jour. Les lignes existantes reprennent l'identité de session.
     */
    public function up(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->string('visiteur', 64)->nullable()->after('session_id');
        });

        DB::table('visites')
            ->whereNull('visiteur')
            ->update(['visiteur' => DB::raw('session_id')]);

        Schema::table('visites', function (Blueprint $table) {
            $table->index(['date', 'visiteur']);
        });
    }

    public function down(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            $table->dropIndex(['date', 'visiteur']);
            $table->dropColumn('visiteur');
        });
    }
};