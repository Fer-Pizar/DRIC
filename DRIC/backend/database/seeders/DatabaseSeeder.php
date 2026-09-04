<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            LanguageSeeder::class,
            PageSeeder::class,
            HomePageSeeder::class,
            PresentationPageSeeder::class,
            CertificatePageSeeder::class,
            AgreementPageSeeder::class,
            AgreementArchivePageSeeder::class,
            ProjectPageSeeder::class,
            ProjectFundingPageSeeder::class,
            MembershipPageSeeder::class,
            NewsPageSeeder::class,
            NormativePageSeeder::class,
            ReportPageSeeder::class,
            ScholarshipBecasPageSeeder::class,
            MobilityPasantiasPageSeeder::class,
        ]);
    }
}
