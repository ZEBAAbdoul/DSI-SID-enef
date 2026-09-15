<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Nationalité
            $table->enum('nationalite_type', ['nationale', 'internationale'])->default('nationale');
            $table->string('pays_nationalite')->nullable();

            // Identité civile
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');

            // Pièce d'identité
            $table->enum('piece_type', ['cnib', 'passeport']);
            $table->string('piece_numero');

            // Contact
            $table->string('telephone_indicatif', 6)->default('+226');
            $table->string('telephone');

            // Résidence
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays_residence')->default('Burkina Faso');

            $table->timestamps();

            $table->unique(['piece_type', 'piece_numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};