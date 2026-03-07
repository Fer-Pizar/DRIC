<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->string('block_type', 50)->default('text');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('link_url')->nullable();
            $table->foreignId('media_asset_id')->nullable()->constrained('media_assets')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropForeign(['media_asset_id']);
            $table->dropColumn([
                'block_type',
                'sort_order',
                'is_active',
                'link_url',
                'media_asset_id',
            ]);
        });
    }
};