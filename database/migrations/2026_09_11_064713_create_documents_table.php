<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')
                ->nullable()
                ->constrained('categories_documents')
                ->nullOnDelete();
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->string('type', 30);
            $table->string('fichier_url', 255)->nullable();
            $table->string('format_fichier', 10)->nullable();
            $table->integer('taille_fichier_ko')->nullable();
            $table->string('acces', 20)->default('public');
            $table->boolean('telechargeable')->default(true);
            $table->string('code_consultation', 30)->nullable();
            $table->string('version', 20)->nullable();
            $table->integer('nombre_telechargements')->default(0);
            $table->timestamp('publie_le')->nullable();
            $table->foreignUuid('publie_par')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });

        // Contraintes CHECK (PostgreSQL)
        DB::statement("ALTER TABLE documents ADD CONSTRAINT documents_type_check 
            CHECK (type IN ('rapport','brochure','texte_reglementaire','support_pedagogique'))");

        DB::statement("ALTER TABLE documents ADD CONSTRAINT documents_acces_check 
            CHECK (acces IN ('public','restreint'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
