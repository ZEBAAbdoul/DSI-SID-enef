<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories_formation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom', 150);
            $table->string('slug', 150)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories_formation');
    }
};