<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Database\Seeder;

class CertificatePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'validar-certificado'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 13]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'certificates.hero'],
            ['section_type' => 'certificate_hero', 'sort_order' => 1, 'is_active' => true, 'settings' => ['editable' => true]]
        );

        foreach ($this->translations() as $locale => $values) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $values['title'],
                    'menu_title' => $values['title'],
                    'subtitle' => $values['subtitle'],
                    'summary' => $values['summary'],
                    'body' => null,
                ]
            );

            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $values['title'],
                    'subtitle' => $values['subtitle'],
                    'summary' => $values['summary'],
                    'body' => null,
                ]
            );
        }
    }

    private function translations(): array
    {
        return [
            'es' => [
                'subtitle' => 'Verificación institucional',
                'title' => 'Verificar Certificado',
                'summary' => 'Consulta la validez de certificados emitidos por la Dirección de Relaciones Internacionales y Convenios mediante un código único de verificación.',
            ],
            'en' => [
                'subtitle' => 'Institutional verification',
                'title' => 'Verify Certificate',
                'summary' => 'Check the validity of certificates issued by the Directorate of International Relations and Agreements using a unique verification code.',
            ],
        ];
    }
}
