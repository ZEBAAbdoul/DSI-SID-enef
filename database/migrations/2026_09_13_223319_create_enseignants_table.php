<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('matricule', 30)->unique()->nullable();
            $table->string('specialite', 150)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('statut', 20)->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};