<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->foreignId('content_block_id')->nullable()->constrained('content_blocks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->dropForeign(['content_block_id']);
            $table->dropColumn('content_block_id');
        });
    }
};