<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute :
     *  - is_publiee (publication / dépublier)
     *  - photo devient JSON (tableau de chemins) → plusieurs photos
     */
    public function up(): void
    {
        if (!Schema::hasColumn('recherches_innovations', 'is_publiee')) {
            DB::statement(
                'ALTER TABLE recherches_innovations ADD COLUMN is_publiee boolean NOT NULL DEFAULT true'
            );
        }

        // photo : varchar -> json. to_jsonb() enveloppe les anciennes valeurs
        // (ex : 'photos/foo.jpg') en chaîne JSON, compatible avec le cast 'array'.
        DB::statement(
            'ALTER TABLE recherches_innovations ALTER COLUMN photo TYPE json USING to_jsonb(photo)::json'
        );
    }

    public function down(): void
    {
        DB::statement(
            'ALTER TABLE recherches_innovations DROP COLUMN IF EXISTS is_publiee'
        );

        DB::statement(
            'ALTER TABLE recherches_innovations ALTER COLUMN photo TYPE varchar USING photo::text'
        );
    }
};