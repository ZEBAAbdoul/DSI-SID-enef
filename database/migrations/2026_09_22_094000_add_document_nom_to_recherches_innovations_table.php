<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Conserver le nom d'origine du document joint (fichier tel qu'uploadé),
     * pour un affichage public lisible (au lieu du nom haché généré par le stockage).
     */
    public function up(): void
    {
        Schema::table('recherches_innovations', function (Blueprint $table) {
            $table->string('document_nom')->nullable()->after('document');
        });
    }

    public function down(): void
    {
        Schema::table('recherches_innovations', function (Blueprint $table) {
            $table->dropColumn('document_nom');
        });
    }
};