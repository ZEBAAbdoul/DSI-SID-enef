// database/migrations/xxxx_xx_xx_create_formations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['academique', 'continue_programmee', 'continue_a_la_carte']);
            $table->foreignUuid('filiere_id')->nullable()->constrained('filieres')->onDelete('set null');
            $table->foreignUuid('categorie_id')->nullable()->constrained('categories_formation')->onDelete('set null');
            $table->string('titre', 255);
            $table->string('slug', 255)->unique();
            $table->text('resume')->nullable();
            $table->text('objectifs')->nullable();
            $table->text('contenu_programme')->nullable();
            $table->string('duree', 50)->nullable();
            $table->string('public_cible', 255)->nullable();
            $table->decimal('cout_indicatif', 12, 2)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->string('mots_cles', 255)->nullable();
            $table->enum('statut', ['ouverte', 'cloturee', 'brouillon'])->default('ouverte');

            // Utiliser uuid pour created_by car users.id est de type uuid
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};