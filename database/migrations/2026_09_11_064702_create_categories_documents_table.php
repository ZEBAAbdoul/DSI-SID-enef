<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 150);
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories_documents')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories_documents');
    }
};