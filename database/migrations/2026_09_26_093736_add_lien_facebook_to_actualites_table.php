<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('actualites', function (Blueprint $table) {
            $table->string('lien_facebook', 255)->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('actualites', function (Blueprint $table) {
            $table->dropColumn('lien_facebook');
        });
    }
};