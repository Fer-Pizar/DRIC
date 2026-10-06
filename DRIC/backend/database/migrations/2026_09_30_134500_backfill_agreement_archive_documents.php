<?php

use App\Models\Language;
use App\Models\Page;
use Database\Seeders\AgreementArchivePageSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            ! Schema::hasTable('pages') ||
            ! Schema::hasTable('languages') ||
            ! Page::query()->where('slug', 'convenios')->exists() ||
            Language::query()->whereIn('code', ['es', 'en'])->count() < 2
        ) {
            return;
        }

        (new AgreementArchivePageSeeder())->run();
    }

    public function down(): void
    {
        //
    }
};
