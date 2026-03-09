<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->unique(['page_id', 'language_id'], 'page_translations_page_language_unique');
            $table->index('page_id', 'page_translations_page_id_index');
            $table->index('language_id', 'page_translations_language_id_index');
        });

        Schema::table('section_translations', function (Blueprint $table) {
            $table->unique(['section_id', 'language_id'], 'section_translations_section_language_unique');
            $table->index('section_id', 'section_translations_section_id_index');
            $table->index('language_id', 'section_translations_language_id_index');
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->unique(['content_block_id', 'language_id'], 'content_block_translations_block_language_unique');
            $table->index('content_block_id', 'content_block_translations_block_id_index');
            $table->index('language_id', 'content_block_translations_language_id_index');
        });

        Schema::table('media_translations', function (Blueprint $table) {
            $table->unique(['media_asset_id', 'language_id'], 'media_translations_media_language_unique');
            $table->index('media_asset_id', 'media_translations_media_asset_id_index');
            $table->index('language_id', 'media_translations_language_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropUnique('page_translations_page_language_unique');
            $table->dropIndex('page_translations_page_id_index');
            $table->dropIndex('page_translations_language_id_index');
        });

        Schema::table('section_translations', function (Blueprint $table) {
            $table->dropUnique('section_translations_section_language_unique');
            $table->dropIndex('section_translations_section_id_index');
            $table->dropIndex('section_translations_language_id_index');
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->dropUnique('content_block_translations_block_language_unique');
            $table->dropIndex('content_block_translations_block_id_index');
            $table->dropIndex('content_block_translations_language_id_index');
        });

        Schema::table('media_translations', function (Blueprint $table) {
            $table->dropUnique('media_translations_media_language_unique');
            $table->dropIndex('media_translations_media_asset_id_index');
            $table->dropIndex('media_translations_language_id_index');
        });
    }
};