<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Journal des visites du site public (une ligne par page vue) :
     * page visitée, adresse IP, lieu déduit, session (hachée).
     * + table de cache de géolocalisation (une ligne par IP).
     */
    public function up(): void
    {
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->timestamp('visite_a');
            $table->date('date')->index();
            $table->string('page', 255);
            $table->string('session_id', 64)->index();
            $table->string('ip', 45)->nullable();
            $table->string('pays', 120)->nullable();
            $table->string('pays_code', 2)->nullable();
            $table->string('region', 120)->nullable();
            $table->string('ville', 120)->nullable();
            $table->timestamps();

            $table->index(['date', 'page']);
        });

        Schema::create('statistiques_geo', function (Blueprint $table) {
            $table->string('ip', 45)->primary();
            $table->string('pays', 120)->nullable();
            $table->string('pays_code', 2)->nullable();
            $table->string('region', 120)->nullable();
            $table->string('ville', 120)->nullable();
            $table->timestamp('recherche_a')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistiques_geo');
        Schema::dropIfExists('visites');
    }
};