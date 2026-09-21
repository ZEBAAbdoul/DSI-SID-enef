<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titre', 150);
            $table->text('description');
            $table->string('categorie', 50)->nullable();
            $table->string('statut', 20)->default('soumise')->index();
            $table->text('reponse')->nullable();
            $table->foreignUuid('traitee_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('traitee_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idees');
    }
};