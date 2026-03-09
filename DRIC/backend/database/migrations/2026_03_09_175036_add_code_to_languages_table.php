<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('code', 10)->nullable()->after('id');
            $table->string('name', 100)->nullable()->after('code');

            $table->unique('code', 'languages_code_unique');
            $table->unique('name', 'languages_name_unique');
        });
    }

    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropUnique('languages_code_unique');
            $table->dropUnique('languages_name_unique');

            $table->dropColumn('code');
            $table->dropColumn('name');
        });
    }
};