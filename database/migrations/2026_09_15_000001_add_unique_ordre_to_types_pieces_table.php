<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE types_pieces ADD CONSTRAINT types_pieces_ordre_unique UNIQUE (ordre)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE types_pieces DROP CONSTRAINT IF EXISTS types_pieces_ordre_unique');
    }
};