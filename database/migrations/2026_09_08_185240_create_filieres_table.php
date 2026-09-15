<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filieres', function (Blueprint $table) {
            $table->uuid('id')->primary(); // doit être uuid, pas id() / bigIncrements
            $table->string('nom', 150);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('code', 20)->unique()->nullable(); // Ex: FGE, SIG, etc.
            $table->string('responsable', 100)->nullable();
            $table->string('email_contact', 100)->nullable();
            $table->boolean('est_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
