<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->cascadeOnDelete();
        });

        Schema::table('page_seos', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->cascadeOnDelete();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->cascadeOnDelete();
        });

        Schema::table('section_translations', function (Blueprint $table) {
            $table->dropForeign(['section_id']);

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->cascadeOnDelete();
        });

        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropForeign(['section_id']);

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->cascadeOnDelete();
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->dropForeign(['content_block_id']);

            $table->foreign('content_block_id')
                ->references('id')
                ->on('content_blocks')
                ->cascadeOnDelete();
        });

        Schema::table('media_translations', function (Blueprint $table) {
            $table->dropForeign(['media_asset_id']);

            $table->foreign('media_asset_id')
                ->references('id')
                ->on('media_assets')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('media_translations', function (Blueprint $table) {
            $table->dropForeign(['media_asset_id']);

            $table->foreign('media_asset_id')
                ->references('id')
                ->on('media_assets')
                ->nullOnDelete();
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->dropForeign(['content_block_id']);

            $table->foreign('content_block_id')
                ->references('id')
                ->on('content_blocks')
                ->nullOnDelete();
        });

        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropForeign(['section_id']);

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->nullOnDelete();
        });

        Schema::table('section_translations', function (Blueprint $table) {
            $table->dropForeign(['section_id']);

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->nullOnDelete();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });

        Schema::table('page_seos', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });

        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropForeign(['page_id']);

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->nullOnDelete();
        });
    }
};