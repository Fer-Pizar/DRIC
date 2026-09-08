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

class CampusLifePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'campus-life'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 14]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $hero = $this->section($page, 'campus.hero', 'campus_hero', 1, $languages, [
            'es' => ['title' => 'Campus Life', 'subtitle' => 'Experiencia UMSS', 'summary' => 'Una universidad enraizada en Cochabamba, conectada con Bolivia y abierta al mundo.', 'body' => null],
            'en' => ['title' => 'Campus Life', 'subtitle' => 'UMSS experience', 'summary' => 'A university rooted in Cochabamba, connected to Bolivia and open to the world.', 'body' => null],
        ]);

        $official = $this->section($page, 'campus.official', 'campus_official_card', 2, $languages, [
            'es' => ['title' => 'Sitio oficial UMSS', 'subtitle' => 'Universidad Mayor de San Simón', 'summary' => 'La Universidad Mayor de San Simón fue fundada por Ley del 5 de noviembre de 1832. Es una universidad pública autónoma con funciones de formación académica, investigación científica y tecnológica e interacción social.', 'body' => null],
            'en' => ['title' => 'Official UMSS website', 'subtitle' => 'Universidad Mayor de San Simón', 'summary' => 'Universidad Mayor de San Simón was founded by law on November 5, 1832. Today it is a public autonomous university with academic, scientific, technological and social outreach functions.', 'body' => null],
        ]);

        $stats = $this->section($page, 'campus.stats', 'campus_stats', 3, $languages, [
            'es' => ['title' => 'Estadísticas', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Statistics', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $features = $this->section($page, 'campus.features', 'campus_features', 4, $languages, [
            'es' => ['title' => 'Características', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Features', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $this->section($page, 'campus.basic', 'campus_basic', 5, $languages, [
            'es' => ['title' => 'Una universidad pública histórica con impacto regional', 'subtitle' => 'Información básica', 'summary' => 'La Universidad Mayor de San Simón fue fundada por Ley del 5 de noviembre de 1832. Es una universidad pública autónoma con funciones de formación académica, investigación científica y tecnológica e interacción social.', 'body' => null],
            'en' => ['title' => 'A historic public university with regional impact', 'subtitle' => 'Basic information', 'summary' => 'Universidad Mayor de San Simón was founded by law on November 5, 1832. Today it is a public autonomous university with academic, scientific, technological and social outreach functions.', 'body' => null],
        ]);

        $stories = $this->section($page, 'campus.stories', 'campus_stories', 6, $languages, [
            'es' => ['title' => 'Vida universitaria', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'University life', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $this->block($hero, 'campus.hero.image', 'campus_hero_image', 1, $languages, [], ['image' => '/images/campus-life/uni-view.png']);
        $this->block($official, 'campus.official.logo', 'campus_logo', 1, $languages, [], ['image' => '/images/campus-life/umss-logo.png', 'url' => 'https://www.umss.edu.bo/']);

        foreach ($this->stats() as $index => $stat) {
            $this->block($stats, "campus.stat.{$index}", 'campus_stat', $index, $languages, [
                'es' => ['title' => $stat['value'], 'summary' => $stat['label_es']],
                'en' => ['title' => $stat['value'], 'summary' => $stat['label_en']],
            ]);
        }

        foreach ($this->features() as $index => $feature) {
            $this->block($features, "campus.feature.{$index}", 'campus_feature', $index, $languages, [
                'es' => ['title' => $feature['title_es'], 'summary' => $feature['text_es']],
                'en' => ['title' => $feature['title_en'], 'summary' => $feature['text_en']],
            ], ['icon' => $feature['icon']]);
        }

        foreach ($this->stories() as $index => $story) {
            $this->block($stories, "campus.story.{$index}", 'campus_story', $index, $languages, [
                'es' => ['title' => $story['title_es'], 'subtitle' => $story['eyebrow_es'], 'summary' => $story['text_es'], 'body' => null, 'cta_label' => $story['button_es']],
                'en' => ['title' => $story['title_en'], 'subtitle' => $story['eyebrow_en'], 'summary' => $story['text_en'], 'body' => null, 'cta_label' => $story['button_en']],
            ], ['image' => $story['image'], 'url' => $story['url']]);
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Campus Life', 'menu_title' => 'Campus Life', 'subtitle' => 'Experiencia UMSS', 'summary' => 'Una universidad enraizada en Cochabamba, conectada con Bolivia y abierta al mundo.', 'body' => null],
            'en' => ['title' => 'Campus Life', 'menu_title' => 'Campus Life', 'subtitle' => 'UMSS experience', 'summary' => 'A university rooted in Cochabamba, connected to Bolivia and open to the world.', 'body' => null],
        ];
    }

    private function stats(): array
    {
        return [
            1 => ['value' => '1832', 'label_es' => 'Año de fundación', 'label_en' => 'Year of foundation'],
            2 => ['value' => '10+', 'label_es' => 'Facultades y unidades académicas', 'label_en' => 'Faculties and academic units'],
            3 => ['value' => '77k+', 'label_es' => 'Estudiantes y comunidad académica', 'label_en' => 'Students and academic community'],
        ];
    }

    private function features(): array
    {
        return [
            1 => ['icon' => 'school', 'title_es' => 'Programas académicos', 'title_en' => 'Academic programs', 'text_es' => 'Formación de pregrado y posgrado en diversas áreas del conocimiento.', 'text_en' => 'Undergraduate and postgraduate education across diverse areas of knowledge.'],
            2 => ['icon' => 'groups', 'title_es' => 'Contribución a la comunidad', 'title_en' => 'Community contribution', 'text_es' => 'Enseñanza, investigación e interacción social vinculadas a las necesidades regionales.', 'text_en' => 'Teaching, research and social outreach connected with regional needs.'],
            3 => ['icon' => 'public', 'title_es' => 'Orientación internacional', 'title_en' => 'International orientation', 'text_es' => 'Cooperación, convenios, movilidad y oportunidades académicas promovidas desde la DRIC.', 'text_en' => 'Cooperation, agreements, mobility and academic opportunities promoted through DRIC.'],
        ];
    }

    private function stories(): array
    {
        return [
            1 => ['eyebrow_es' => 'Características de la universidad', 'eyebrow_en' => 'University character', 'title_es' => 'Bibliotecas y espacios de aprendizaje', 'title_en' => 'Libraries and learning spaces', 'text_es' => 'Facilita el acceso a libros, tesis, artículos científicos y publicaciones académicas de sus facultades y centros de investigación, promoviendo la consulta, difusión y acceso al conocimiento académico y científico de la comunidad universitaria.', 'text_en' => 'Provides access to books, theses, scientific articles and academic publications from its faculties and research centers, promoting the consultation, dissemination and access to academic and scientific knowledge for the university community.', 'button_es' => null, 'button_en' => null, 'image' => '/images/campus-life/library.png', 'url' => 'http://bibliotecas.umss.edu.bo/site/php/index.php'],
            2 => ['eyebrow_es' => 'Fortalezas', 'eyebrow_en' => 'Strengths', 'title_es' => 'Facultades y carreras', 'title_en' => 'Faculties and careers', 'text_es' => 'La UMSS cuenta con una amplia diversidad de facultades que abarcan distintas áreas del conocimiento, ofreciendo formación académica en ciencias, tecnología, salud, humanidades, ciencias sociales y otras disciplinas. Esta variedad fortalece una comunidad universitaria multidisciplinaria y diversa.', 'text_en' => 'UMSS has a wide diversity of faculties covering different areas of knowledge, offering academic training in sciences, technology, health, humanities, social sciences and other disciplines. This variety strengthens a multidisciplinary and diverse university community.', 'button_es' => null, 'button_en' => null, 'image' => '/images/campus-life/faculties.png', 'url' => 'https://www.umss.edu.bo/facultades/'],
            3 => ['eyebrow_es' => 'Historia', 'eyebrow_en' => 'History', 'title_es' => 'INIAM Museo UMSS', 'title_en' => 'INIAM UMSS Museum', 'text_es' => 'Fundado en 1951 como Museo Arqueológico y Etnográfico de la UMSS, dio origen en 1963 a la primera Escuela de Antropología y Arqueología de Bolivia. En 1980 fue consolidado como el Instituto de Investigaciones Antropológicas y Museo Arqueológico (INIAM-UMSS).', 'text_en' => "Founded in 1951 as the Archaeological and Ethnographic Museum of UMSS, it gave rise in 1963 to Bolivia's first School of Anthropology and Archaeology. In 1980, it was consolidated as the Institute of Anthropological Research and Archaeological Museum (INIAM-UMSS).", 'button_es' => null, 'button_en' => null, 'image' => '/images/campus-life/uni-view.png', 'url' => 'https://museo.umss.edu.bo/'],
            4 => ['eyebrow_es' => 'Recorriendo Cochabamba', 'eyebrow_en' => 'Getting around', 'title_es' => 'Más allá del campus', 'title_en' => 'Beyond campus', 'text_es' => 'La vida universitaria también se conecta con Cochabamba: su centro histórico, cultura, gastronomía, paisajes y espacios públicos.', 'text_en' => 'Campus life is also connected to Cochabamba: its historic center, culture, gastronomy, landscapes and public spaces.', 'button_es' => 'Explorar Cochabamba', 'button_en' => 'Explore Cochabamba', 'image' => '/images/campus-life/cochabamba.png', 'url' => 'https://visita.cochabamba.bo/'],
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
            ['block_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'data' => $data, 'media_asset_id' => null]
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
