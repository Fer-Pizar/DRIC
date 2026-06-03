<?php

namespace Database\Seeders;

use App\Models\CertificateVerification;
use Illuminate\Database\Seeder;

class CertificateVerificationSeeder extends Seeder
{
    public function run(): void
    {
        CertificateVerification::updateOrCreate(
            ['code' => '1234ABC'],
            [
                'full_name' => 'Fernanda',
                'certificate_type' => 'Práctica Empresarial',
                'start_date' => '2026-02-28',
                'end_date' => '2026-06-29',
                'is_active' => true,
            ]
        );
    }
}