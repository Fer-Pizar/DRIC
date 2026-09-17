<?php

namespace Database\Seeders;

use App\Models\CertificateVerification;
use Illuminate\Database\Seeder;

class CertificateVerificationSeeder extends Seeder
{
    public function run(): void
    {
        $certificates = [
            [
                'code' => 'B7T3SG9',
                'full_name' => 'Registro protegido',
                'description' => 'Certificado histórico protegido.',
                'description_en' => 'Protected historical certificate.',
                'issue_date' => '2026-01-01',
            ],
            [
                'code' => 'X4D8R1Q',
                'full_name' => 'Registro protegido',
                'description' => 'Certificado histórico protegido.',
                'description_en' => 'Protected historical certificate.',
                'issue_date' => '2026-01-01',
            ],
            [
                'code' => 'A7K9P2M',
                'full_name' => 'Registro protegido',
                'description' => 'Certificado histórico protegido.',
                'description_en' => 'Protected historical certificate.',
                'issue_date' => '2026-01-01',
            ],
        ];

        foreach ($certificates as $certificate) {
            CertificateVerification::firstOrCreate(
                ['code' => $certificate['code']],
                [
                    'full_name' => $certificate['full_name'],
                    'certificate_type' => 'Certificado DRIC',
                    'certificate_type_en' => 'DRIC Certificate',
                    'description' => $certificate['description'],
                    'description_en' => $certificate['description_en'],
                    'issue_date' => $certificate['issue_date'],
                    'is_active' => true,
                ]
            );
        }
    }
}
