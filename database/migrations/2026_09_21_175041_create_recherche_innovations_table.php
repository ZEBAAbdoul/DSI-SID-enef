<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recherches_innovations', function (Blueprint $table) {
   $table->uuid('id')->primary();
            $table->string('slug', 150)->unique();
            $table->string('titre', 255);
            $table->text('chapo')->nullable();
            $table->longText('contenu')->nullable();
            $table->string('photo')->nullable();
            $table->string('url_video')->nullable();
            $table->string('document')->nullable();
            $table->enum('type', ['recherche', 'innovation']);
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recherches_innovations');
    }
};
