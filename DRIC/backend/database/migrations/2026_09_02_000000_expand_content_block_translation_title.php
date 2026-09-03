<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE content_block_translations ALTER COLUMN title TYPE TEXT');
    }

    public function down(): void
    {
        DB::statement('UPDATE content_block_translations SET title = LEFT(title, 255) WHERE title IS NOT NULL');
        DB::statement('ALTER TABLE content_block_translations ALTER COLUMN title TYPE VARCHAR(255)');
    }
};
