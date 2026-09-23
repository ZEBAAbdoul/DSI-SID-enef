<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute le contact RH (téléphone du service des ressources humaines).
     *
     * Cette colonne figure aussi dans la migration de création de la table
     * (déjà exécutée) : on vérifie donc qu'elle n'existe pas déjà pour être
     * idempotent, quel que soit l'état de la base.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('parametres_site', 'contact_rh')) {
            Schema::table('parametres_site', function (Blueprint $table) {
                $table->string('contact_rh', 20)->nullable()->after('email_contact');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('parametres_site', 'contact_rh')) {
            Schema::table('parametres_site', function (Blueprint $table) {
                $table->dropColumn('contact_rh');
            });
        }
    }
};