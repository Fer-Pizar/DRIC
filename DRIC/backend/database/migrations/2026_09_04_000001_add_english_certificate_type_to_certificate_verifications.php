<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_verifications', function (Blueprint $table) {
            $table->string('certificate_type_en')->nullable()->after('certificate_type');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_verifications', function (Blueprint $table) {
            $table->dropColumn('certificate_type_en');
        });
    }
};
