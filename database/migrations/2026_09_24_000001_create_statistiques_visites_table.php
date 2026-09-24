<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Statistiques de fréquentation du site public :
     * une ligne par jour avec le nombre de pages vues et de visiteurs uniques.
     */
    public function up(): void
    {
        Schema::create('statistiques_visites', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->unsignedInteger('vues')->default(0);
            $table->unsignedInteger('visiteurs')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistiques_visites');
    }
};