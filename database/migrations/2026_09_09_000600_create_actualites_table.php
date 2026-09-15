// database/migrations/xxxx_xx_xx_create_actualites_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actualites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug', 150)->unique();
            $table->string('titre', 255);
            $table->text('chapo')->nullable();
            $table->text('contenu');
            $table->string('image_couverture_url', 255)->nullable();
            $table->enum('type', ['institutionnelle', 'formation', 'evenement', 'partenariat', 'communique'])->default('institutionnelle');
            $table->smallInteger('ordre_menu')->default(0);
            $table->boolean('is_publiee')->default(true);
            $table->string('meta_description', 255)->nullable();

            // Utiliser uuid pour les clés étrangères car users.id est de type uuid
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};