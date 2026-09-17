<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Database\Seeder;

class ReportPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'informes-gestion'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 11]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $hero = $this->section($page, 'reports.hero', 'reports_hero', 1, $languages, [
            'es' => ['title' => 'Informes de Gestión', 'subtitle' => 'Transparencia institucional', 'summary' => 'Consulta los informes institucionales de la Dirección de Relaciones Internacionales y Convenios, organizados por gestión para fortalecer la transparencia y el acceso público a la información.', 'body' => 'Una colección histórica de gestiones institucionales preparada para consulta pública y descarga documental.'],
            'en' => ['title' => 'Management Reports', 'subtitle' => 'Institutional transparency', 'summary' => 'Review the institutional reports of the Directorate of International Relations and Agreements, organized by year to strengthen transparency and public access to information.', 'body' => 'A historical collection of institutional terms prepared for public consultation and document downloads.'],
        ]);

        $archive = $this->section($page, 'reports.archive', 'reports_archive', 2, $languages, [
            'es' => ['title' => 'Archivo de informes', 'subtitle' => 'Explorar documentos', 'summary' => 'Buscar informe...', 'body' => null],
            'en' => ['title' => 'Reports archive', 'subtitle' => 'Explore documents', 'summary' => 'Search report...', 'body' => null],
        ], [
            'archive_label_es' => 'Archivo DRIC',
            'archive_label_en' => 'DRIC Archive',
            'cover_eyebrow_es' => 'Dirección de',
            'cover_eyebrow_en' => 'Directorate of',
            'cover_title_es' => 'Relaciones Internacionales y Convenios',
            'cover_title_en' => 'International Relations and Agreements',
            'year_label_es' => 'Gestión',
            'year_label_en' => 'Year',
            'download_label_es' => 'Descargar PDF',
            'download_label_en' => 'Download PDF',
        ]);

        unset($hero);

        if (ContentBlock::query()->where('section_id', $archive->id)->exists()) {
            return;
        }

        foreach ($this->reports() as $index => $report) {
            $block = ContentBlock::create([
                'section_id' => $archive->id,
                'link_url' => 'reports.item.'.$report['year'],
                'block_type' => 'management_report',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => [
                    'year' => $report['year'],
                    'download_url' => '#',
                ],
            ]);

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $report['title'][$locale],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                        'cta_label' => $report['date'][$locale],
                    ]
                );
            }
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Informes de Gestión', 'menu_title' => 'Informes de Gestión', 'subtitle' => 'Transparencia institucional', 'summary' => 'Consulta los informes institucionales de la Dirección de Relaciones Internacionales y Convenios, organizados por gestión para fortalecer la transparencia y el acceso público a la información.', 'body' => null],
            'en' => ['title' => 'Management Reports', 'menu_title' => 'Management Reports', 'subtitle' => 'Institutional transparency', 'summary' => 'Review the institutional reports of the Directorate of International Relations and Agreements, organized by year to strengthen transparency and public access to information.', 'body' => null],
        ];
    }

    private function reports(): array
    {
        return [
            ['year' => '2023', 'title' => ['es' => 'Informe de Gestión 2023', 'en' => 'Management Report 2023'], 'date' => ['es' => 'Oct 15, 2024', 'en' => 'Oct 15, 2024']],
            ['year' => '2022', 'title' => ['es' => 'Informe de Gestión 2022', 'en' => 'Management Report 2022'], 'date' => ['es' => 'Nov 29, 2023', 'en' => 'Nov 29, 2023']],
            ['year' => '2021', 'title' => ['es' => 'Informe DRIC 2021', 'en' => 'DRIC Report 2021'], 'date' => ['es' => 'Mar 3, 2022', 'en' => 'Mar 3, 2022']],
            ['year' => '2020', 'title' => ['es' => 'Informe DRIC 2020', 'en' => 'DRIC Report 2020'], 'date' => ['es' => 'Dic 28, 2020', 'en' => 'Dec 28, 2020']],
            ['year' => '2019', 'title' => ['es' => 'Informe DRIC 2019', 'en' => 'DRIC Report 2019'], 'date' => ['es' => 'Dic 27, 2019', 'en' => 'Dec 27, 2019']],
            ['year' => '2018', 'title' => ['es' => 'Informe DRIC 2018', 'en' => 'DRIC Report 2018'], 'date' => ['es' => 'Dic 27, 2018', 'en' => 'Dec 27, 2018']],
            ['year' => '2017', 'title' => ['es' => 'Informe DRIC 2017', 'en' => 'DRIC Report 2017'], 'date' => ['es' => 'Dic 29, 2017', 'en' => 'Dec 29, 2017']],
        ];
    }

    private function section(Page $page, string $key, string $type, int $sortOrder, $languages, array $translations, array $settings = []): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true, ...$settings]]
        );

        foreach ($translations as $locale => $values) {
            SectionTranslation::updateOrCreate(['section_id' => $section->id, 'language_id' => $languages[$locale]->id], $values);
        }

        return $section;
    }
}
