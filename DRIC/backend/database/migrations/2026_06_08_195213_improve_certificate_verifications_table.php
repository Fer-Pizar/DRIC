<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_verifications', function (Blueprint $table) {
            $table->renameColumn('start_date', 'issue_date');
            $table->dropColumn('end_date');
            $table->text('description')->nullable()->after('certificate_type');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_verifications', function (Blueprint $table) {
            $table->renameColumn('issue_date', 'start_date');
            $table->date('end_date')->nullable()->after('start_date');
            $table->dropColumn('description');
        });
    }
};