<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions_formation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('formation_id')
                  ->constrained('formations')
                  ->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->string('lieu', 150)->nullable();
            $table->integer('places_totales')->nullable();
            $table->integer('places_disponibles')->nullable();
            $table->string('statut', 20)->default('ouverte');

            // Créateur de la session
            $table->foreignUuid('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            $table->index('statut');
            $table->index('date_debut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions_formation');
    }
};