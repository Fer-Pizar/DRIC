<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_change_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('certificate_id')->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('before')->nullable();
            $table->json('after');
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificate_change_logs');
    }
};
