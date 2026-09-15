<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partenaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 150);
            $table->string('logo_url', 255)->nullable();
            $table->string('site_web', 255)->nullable();
            $table->string('type', 30)->default('institutionnel');
            $table->text('description')->nullable();
            $table->integer('ordre_affichage')->default(0);
            $table->boolean('actif')->default(true);
        });

        DB::statement("ALTER TABLE partenaires ADD CONSTRAINT partenaires_type_check 
            CHECK (type IN ('institutionnel','financier','technique','academique','collectivite'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('partenaires');
    }
};