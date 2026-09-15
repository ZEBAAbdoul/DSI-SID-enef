<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('candidat_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignUuid('formation_id')
                ->nullable()
                ->constrained('formations')
                ->nullOnDelete();
            $table->foreignUuid('session_formation_id')
                ->nullable()
                ->constrained('sessions_formation')
                ->nullOnDelete();
            $table->string('numero_dossier', 30)->unique();
            $table->string('statut', 20)->default('depose');
            $table->text('motif_rejet')->nullable();
            $table->timestamp('date_soumission')->nullable();
            $table->timestamp('date_traitement')->nullable();
            $table->foreignUuid('traite_par')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE inscriptions ADD CONSTRAINT inscriptions_statut_check 
            CHECK (statut IN ('depose','en_cours','incomplet','valide','rejete'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
