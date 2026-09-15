<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('filiere_id')
                ->nullable()
                ->constrained('filieres')
                ->nullOnDelete();
            $table->string('nom', 150);
            $table->string('code', 20)->unique()->nullable();
            $table->decimal('coefficient', 4, 2)->default(1);
            $table->integer('volume_horaire')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};