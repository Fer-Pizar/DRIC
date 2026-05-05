<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            if (!Schema::hasColumn('content_blocks', 'data')) {
                $table->jsonb('data')->nullable();
            }
        });

        Schema::table('sections', function (Blueprint $table) {
            if (!Schema::hasColumn('sections', 'settings')) {
                $table->jsonb('settings')->nullable();
            }
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('content_block_translations', 'cta_label')) {
                $table->string('cta_label')->nullable();
            }

            if (!Schema::hasColumn('content_block_translations', 'secondary_cta_label')) {
                $table->string('secondary_cta_label')->nullable();
            }
        });

        Schema::table('page_seos', function (Blueprint $table) {
            if (!Schema::hasColumn('page_seos', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }

            if (!Schema::hasColumn('page_seos', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }

            if (!Schema::hasColumn('page_seos', 'canonical_url')) {
                $table->string('canonical_url')->nullable();
            }

            if (!Schema::hasColumn('page_seos', 'open_graph_image_id')) {
                $table->foreignId('open_graph_image_id')
                    ->nullable()
                    ->constrained('media_assets')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('page_seos', 'structured_data')) {
                $table->jsonb('structured_data')->nullable();
            }
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_logs', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('audit_logs', 'action')) {
                $table->string('action')->nullable();
            }

            if (!Schema::hasColumn('audit_logs', 'auditable_type')) {
                $table->string('auditable_type')->nullable();
            }

            if (!Schema::hasColumn('audit_logs', 'auditable_id')) {
                $table->unsignedBigInteger('auditable_id')->nullable();
            }

            if (!Schema::hasColumn('audit_logs', 'old_values')) {
                $table->jsonb('old_values')->nullable();
            }

            if (!Schema::hasColumn('audit_logs', 'new_values')) {
                $table->jsonb('new_values')->nullable();
            }

            if (!Schema::hasColumn('audit_logs', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn([
                'ip_address',
                'new_values',
                'old_values',
                'auditable_id',
                'auditable_type',
                'action',
            ]);

            if (Schema::hasColumn('audit_logs', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('page_seos', function (Blueprint $table) {
            if (Schema::hasColumn('page_seos', 'open_graph_image_id')) {
                $table->dropConstrainedForeignId('open_graph_image_id');
            }

            $table->dropColumn([
                'meta_title',
                'meta_description',
                'canonical_url',
                'structured_data',
            ]);
        });

        Schema::table('content_block_translations', function (Blueprint $table) {
            $table->dropColumn([
                'cta_label',
                'secondary_cta_label',
            ]);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('settings');
        });

        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};