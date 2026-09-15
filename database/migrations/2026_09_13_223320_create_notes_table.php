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
            $table->foreignId('enseignant_id')
                ->constrained('enseignants')
                ->cascadeOnDelete();
            $table->foreignUuid('eleve_id')
                ->constrained('users')
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
            $table->decimal('note', 5, 2);
            $table->decimal('note_max', 5, 2)->default(20);
            $table->text('commentaire')->nullable();
            $table->date('date_evaluation')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE notes ADD CONSTRAINT notes_type_evaluation_check 
            CHECK (type_evaluation IN ('controle','examen','tp','oral','projet'))");

        DB::statement("ALTER TABLE notes ADD CONSTRAINT notes_note_check 
            CHECK (note >= 0 AND note <= note_max)");
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};