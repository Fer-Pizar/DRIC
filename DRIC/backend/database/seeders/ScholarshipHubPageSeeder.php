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

class ScholarshipHubPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'becas-movilidad'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 5]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $hero = $this->section($page, 'scholarship_hub.hero', 'scholarship_hub_hero', 1, $languages, [
            'es' => ['title' => 'Becas y Movilidad', 'subtitle' => 'DRIC · UMSS', 'summary' => 'La DRIC impulsa la internacionalización académica mediante becas, programas de movilidad, pasantías, convocatorias y orientación institucional para la comunidad nacional e internacional.', 'body' => null],
            'en' => ['title' => 'Scholarships and Mobility', 'subtitle' => 'DRIC · UMSS', 'summary' => 'DRIC promotes academic internationalization through scholarships, mobility programs, internships, calls and institutional guidance for national and international communities.', 'body' => null],
        ]);

        $this->section($page, 'scholarship_hub.explore', 'scholarship_hub_explore', 2, $languages, [
            'es' => ['title' => 'Rutas académicas internacionales', 'subtitle' => 'Explora oportunidades', 'summary' => 'Esta sección reúne becas, movilidad, pasantías, convocatorias e información institucional para orientar a la comunidad universitaria.', 'body' => null],
            'en' => ['title' => 'International academic pathways', 'subtitle' => 'Explore opportunities', 'summary' => 'This section brings together scholarships, mobility, internships, calls and institutional information to guide the university community.', 'body' => null],
        ]);

        $cards = $this->section($page, 'scholarship_hub.cards', 'scholarship_hub_cards', 3, $languages, [
            'es' => ['title' => 'Opciones principales', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Main options', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $this->block($hero, 'scholarship_hub.hero.meta', 'scholarship_hub_meta', 1, $languages, [], ['locked_design' => true]);

        foreach ($this->cards() as $index => $card) {
            $this->block($cards, "scholarship_hub.card.{$index}", 'scholarship_hub_card', $index, $languages, [
                'es' => ['title' => $card['title_es'], 'summary' => $card['description_es'], 'cta_label' => $card['label_es']],
                'en' => ['title' => $card['title_en'], 'summary' => $card['description_en'], 'cta_label' => $card['label_en']],
            ], [
                'href' => $card['href'],
                'icon' => $card['icon'],
                'accent' => $card['accent'],
                'locked_design' => true,
            ]);
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Becas y Movilidad', 'menu_title' => 'Becas y Movilidad', 'subtitle' => 'DRIC · UMSS', 'summary' => 'La DRIC impulsa la internacionalización académica mediante becas, programas de movilidad, pasantías, convocatorias y orientación institucional para la comunidad nacional e internacional.', 'body' => null],
            'en' => ['title' => 'Scholarships and Mobility', 'menu_title' => 'Scholarships and Mobility', 'subtitle' => 'DRIC · UMSS', 'summary' => 'DRIC promotes academic internationalization through scholarships, mobility programs, internships, calls and institutional guidance for national and international communities.', 'body' => null],
        ];
    }

    private function cards(): array
    {
        return [
            1 => ['title_es' => 'Becas de pregrado y posgrado', 'title_en' => 'Undergraduate and postgraduate scholarships', 'description_es' => 'Programas de becas ofertados por gobiernos, universidades y organismos internacionales.', 'description_en' => 'Scholarship opportunities offered by governments, universities and international organizations.', 'label_es' => 'Ver becas', 'label_en' => 'View scholarships', 'href' => '/becas-movilidad/becas', 'icon' => 'school', 'accent' => '#E30613'],
            2 => ['title_es' => 'Movilidad y pasantías internacionales', 'title_en' => 'Mobility and international internships', 'description_es' => 'Programas de movilidad docente, estudiantil, administrativa y pasantías internacionales.', 'description_en' => 'Academic, teaching, student and administrative mobility programs.', 'label_es' => 'Ver programas', 'label_en' => 'View programs', 'href' => '/becas-movilidad/movilidad-pasantias', 'icon' => 'flight', 'accent' => '#003770'],
            3 => ['title_es' => 'Premios, eventos, cursos y concursos', 'title_en' => 'Awards, events, courses and contests', 'description_es' => 'Convocatorias, cursos, concursos y oportunidades académicas para la comunidad universitaria.', 'description_en' => 'Calls, courses, contests and academic opportunities for the university community.', 'label_es' => 'Ver convocatorias', 'label_en' => 'View calls', 'href' => '/becas-movilidad/premios-eventos-cursos-concursos', 'icon' => 'awards', 'accent' => '#E30613'],
            4 => ['title_es' => 'Información para nacionales y extranjeros', 'title_en' => 'Information for nationals and foreigners', 'description_es' => 'Información útil, trámites y orientación para ciudadanos nacionales y extranjeros.', 'description_en' => 'Useful information, procedures and guidance for national and international visitors.', 'label_es' => 'Ver información', 'label_en' => 'View information', 'href' => '/becas-movilidad/informacion-nacionales-extranjeros', 'icon' => 'info', 'accent' => '#003770'],
        ];
    }

    private function section(Page $page, string $key, string $type, int $sortOrder, $languages, array $translations): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );

        foreach ($translations as $locale => $values) {
            SectionTranslation::updateOrCreate(['section_id' => $section->id, 'language_id' => $languages[$locale]->id], $values);
        }

        return $section;
    }

    private function block(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): void
    {
        $block = ContentBlock::updateOrCreate(
            ['section_id' => $section->id, 'link_url' => $key],
            ['block_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'data' => $data]
        );

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'] ?? null,
                    'subtitle' => $translations[$locale]['subtitle'] ?? null,
                    'summary' => $translations[$locale]['summary'] ?? null,
                    'body' => $translations[$locale]['body'] ?? null,
                    'cta_label' => $translations[$locale]['cta_label'] ?? null,
                ]
            );
        }
    }
}
