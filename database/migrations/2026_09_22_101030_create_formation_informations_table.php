<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Table de référence pour les informations complémentaires affichées
 * sur le catalogue de formations : frais annexes, modalités de paiement
 * (classes intermédiaires / terminales) et composition du dossier.
 *
 * Une ligne = un élément d'une catégorie, ordonné par `ordre`.
 * `valeur` est nullable : pour la catégorie "dossier", `libelle` porte
 * la phrase complète et `valeur` reste vide.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_informations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('categorie'); // frais | paiement_intermediaire | paiement_terminale | dossier
            $table->string('libelle');
            $table->string('valeur')->nullable();
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->timestamps();

            $table->index('categorie');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_informations');
    }
};