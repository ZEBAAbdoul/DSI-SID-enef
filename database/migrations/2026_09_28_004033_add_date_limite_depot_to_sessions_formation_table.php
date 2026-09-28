<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions_formation', function (Blueprint $table) {
            $table->date('date_limite_depot')->nullable()->after('date_fin');
            $table->index('date_limite_depot');
        });
    }

    public function down(): void
    {
        Schema::table('sessions_formation', function (Blueprint $table) {
            $table->dropIndex(['date_limite_depot']);
            $table->dropColumn('date_limite_depot');
        });
    }
};