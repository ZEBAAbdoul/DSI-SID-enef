<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unites_pedagogiques', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedSmallInteger('numero');
            $table->string('titre', 255);
            $table->string('slug', 255)->unique();
            $table->string('note', 100)->nullable();

            $table->text('concept');
            $table->text('objectif_general');

            // Tableau de chaînes : ["Maîtriser ...", "Identifier ...", ...]
            $table->json('objectifs_specifiques')->nullable();

            // Tableau d'objets : [{"nom": "...", "etat": "...", "apps": "..."}, ...]
            $table->json('sous_unites')->nullable();

            $table->unsignedSmallInteger('ordre')->default(0);
            $table->boolean('est_publie')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unites_pedagogiques');
    }
};