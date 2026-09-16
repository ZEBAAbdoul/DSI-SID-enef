<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignUuid('enseignant_id')
                ->constrained('enseignants')
                ->cascadeOnDelete();

            $table->foreignUuid('formation_id')
                ->constrained('formations')
                ->cascadeOnDelete();

            $table->foreignUuid('session_formation_id')
                ->nullable()
                ->constrained('sessions_formation')
                ->nullOnDelete();

            $table->foreignId('matiere_id')
                ->constrained('matieres')
                ->cascadeOnDelete();

            $table->string('type_evaluation', 30)->default('controle');

            // Fichier déposé par l'enseignant (remplace note/note_max)
            $table->string('fichier');            // chemin de stockage
            $table->string('nom_original');       // nom original du fichier
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('taille')->nullable(); // en octets

            $table->text('commentaire')->nullable();
            $table->date('date_evaluation')->nullable();

            $table->timestamps();
        });

        DB::statement("ALTER TABLE notes ADD CONSTRAINT notes_type_evaluation_check 
            CHECK (type_evaluation IN ('controle','examen','tp','oral','projet'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};