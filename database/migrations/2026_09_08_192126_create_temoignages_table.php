<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temoignages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('contenu');
            $table->string('auteur', 150);
            $table->string('fonction', 150)->nullable();
            $table->integer('note')->default(5)->check('note BETWEEN 1 AND 5');
            $table->string('formation_concernee', 150)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->boolean('est_publie')->default(true);
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temoignages');
    }
};