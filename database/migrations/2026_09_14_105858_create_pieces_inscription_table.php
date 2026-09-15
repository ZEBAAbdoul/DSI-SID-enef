<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pieces_inscription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscription_id')
                ->constrained('inscriptions')
                ->cascadeOnDelete();
            $table->string('type_piece', 40);
            $table->foreign('type_piece')
                ->references('code')
                ->on('types_pieces')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->string('fichier_url', 255);
            $table->string('format_fichier', 10)->nullable();
            $table->integer('taille_fichier_ko')->nullable();
            $table->string('statut_verification', 20)->default('en_attente');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE pieces_inscription ADD CONSTRAINT pieces_statut_verif_check 
            CHECK (statut_verification IN ('en_attente','conforme','non_conforme'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces_inscription');
    }
};