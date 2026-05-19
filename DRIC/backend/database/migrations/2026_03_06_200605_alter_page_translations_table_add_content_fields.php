<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->foreignId('language_id')->nullable()->constrained('languages')->nullOnDelete();
            $table->string('title')->nullable();
            $table->string('menu_title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropForeign(['language_id']);
            $table->dropColumn([
                'language_id',
                'title',
                'menu_title',
                'subtitle',
                'summary',
                'body',
            ]);
        });
    }
};