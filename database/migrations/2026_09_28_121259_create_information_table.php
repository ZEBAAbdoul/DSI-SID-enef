<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('informations', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('titre', 200);
        $table->text('contenu');
        $table->string('cible', 20)->default('tous');   // user | enseignant | tous
        $table->string('fichier_path')->nullable();
        $table->string('fichier_nom')->nullable();      // nom d'origine affiché au téléchargement
        $table->boolean('est_publie')->default(true);
        $table->timestamp('publie_le')->nullable();
        $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();

        $table->index(['cible', 'est_publie']);
    });
}

public function down(): void
{
    Schema::dropIfExists('informations');
}
};
