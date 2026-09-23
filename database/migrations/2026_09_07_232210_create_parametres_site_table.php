<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parametres_site', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom_site', 150);
            $table->string('slogan', 255)->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->string('favicon_url', 255)->nullable();
            $table->string('mot_dg_titre', 150)->nullable();
            $table->text('mot_dg_contenu')->nullable();
            $table->string('mot_dg_photo_url', 255)->nullable();
            $table->string('mot_dg_nom', 150)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email_contact', 150)->nullable();
            $table->smallInteger('annee_creation')->nullable();
            $table->smallInteger('personne_forme')->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('meta_description', 255)->nullable();


            // Champ UUID pour la clé étrangère
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametres_site');
    }
};
