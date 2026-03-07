<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_translations', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable()->constrained('languages')->nullOnDelete();
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('media_translations', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn([
                'language_id',
                'alt_text',
                'caption',
            ]);
        });
    }
};