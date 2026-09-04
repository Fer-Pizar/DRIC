<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'noticias'],
            [
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => 8,
                'parent_id' => null,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $this->section($page, 'news.hero', 'news_hero', 1, $languages, [
            'es' => ['title' => 'Noticias', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Noticias institucionales, movilidad académica, cooperación internacional y actividades destacadas de la DRIC.', 'body' => null],
            'en' => ['title' => 'News', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Institutional news, academic mobility updates, international cooperation activities and opportunities from DRIC.', 'body' => null],
        ]);

        $list = $this->section($page, 'news.list', 'news_list', 2, $languages, [
            'es' => ['title' => 'Últimas noticias institucionales', 'subtitle' => 'Explorar', 'summary' => 'Buscar noticias...', 'body' => 'Leer más'],
            'en' => ['title' => 'Latest institutional updates', 'subtitle' => 'Explore', 'summary' => 'Search news...', 'body' => 'Read more'],
        ]);

        $this->seedLegacyNews($list, $languages);
        $this->sortNews($list);
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Noticias', 'menu_title' => 'Noticias', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Noticias institucionales, movilidad académica, cooperación internacional y actividades destacadas de la DRIC.', 'body' => null],
            'en' => ['title' => 'News', 'menu_title' => 'News', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Institutional news, academic mobility updates, international cooperation activities and opportunities from DRIC.', 'body' => null],
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

    private function seedLegacyNews(Section $section, $languages): void
    {
        foreach ($this->legacyNews() as $index => $item) {
            $block = ContentBlock::query()
                ->where('section_id', $section->id)
                ->whereHas('translations', fn ($query) => $query
                    ->where('language_id', $languages['es']->id)
                    ->where('title', $item['title_es']))
                ->first();

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'news.legacy.'.Str::uuid()->toString(),
                ]);
            }

            $block->fill([
                'block_type' => 'news_item',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => [
                    'slug' => Str::after($item['href'], '/noticias/'),
                    'href' => $item['href'],
                    'published_at' => $item['published_at'],
                ],
            ]);

            $block->save();

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $item["title_{$locale}"],
                        'subtitle' => $item["category_{$locale}"],
                        'summary' => $item["excerpt_{$locale}"],
                        'body' => null,
                        'cta_label' => $item["date_{$locale}"],
                    ]
                );
            }
        }
    }

    private function sortNews(Section $section): void
    {
        $blocks = ContentBlock::query()
            ->where('section_id', $section->id)
            ->get()
            ->sortByDesc(fn (ContentBlock $block) => $block->data['published_at'] ?? '')
            ->values();

        foreach ($blocks as $index => $block) {
            $block->update(['sort_order' => $index + 1]);
        }
    }

    private function legacyNews(): array
    {
        return [
            ['title_es' => 'Movilidad académica en el marco del Programa Escala Docente (PED) de AUGM, Brasil', 'title_en' => 'Academic mobility through the AUGM Faculty Scale Program (PED), Brazil', 'date_es' => 'Dic 17, 2024', 'date_en' => 'Dec 17, 2024', 'published_at' => '2024-12-17', 'category_es' => 'Movilidad académica', 'category_en' => 'Academic mobility', 'excerpt_es' => 'Marco Antonio Alcalá Cuba, jefe del Departamento de Desarrollo Curricular de la UMSS, compartió una experiencia de movilidad docente en el marco del Programa Escala Docente de AUGM.', 'excerpt_en' => 'Marco Antonio Alcalá Cuba, head of UMSS Curriculum Development, shared a faculty mobility experience through the AUGM Faculty Scale Program.', 'href' => '/noticias/movilidad-academica-escala-docente-augm-brasil'],
            ['title_es' => 'Serie de conversatorios con investigadores que participaron en las 31° Jornadas de Jóvenes Investigadores de AUGM', 'title_en' => 'Talk series with researchers who participated in the 31st AUGM Young Researchers Conference', 'date_es' => 'Dic 10, 2024', 'date_en' => 'Dec 10, 2024', 'published_at' => '2024-12-10', 'category_es' => 'Investigación', 'category_en' => 'Research', 'excerpt_es' => 'Durante la tercera Semana Internacional de la Ciencia, la DRIC impulsó espacios de diálogo con investigadores participantes de las Jornadas de Jóvenes Investigadores.', 'excerpt_en' => 'During the third International Science Week, DRIC promoted dialogue spaces with researchers who participated in the Young Researchers Conference.', 'href' => '/noticias/conversatorios-jovenes-investigadores-31-jji-augm'],
            ['title_es' => 'Movilidad académica administrativa: experiencia de Jimmy Delgado en la UNJU, Argentina', 'title_en' => 'Administrative academic mobility: Jimmy Delgado\'s experience at UNJU, Argentina', 'date_es' => 'Dic 4, 2024', 'date_en' => 'Dec 4, 2024', 'published_at' => '2024-12-04', 'category_es' => 'Movilidad académica', 'category_en' => 'Academic mobility', 'excerpt_es' => 'Jimmy Delgado Villca, docente de la Facultad de Humanidades y Ciencias de la Educación, realizó una experiencia académica en la Universidad Nacional de Jujuy.', 'excerpt_en' => 'Jimmy Delgado Villca, faculty member from Humanities and Education Sciences, completed an academic experience at Universidad Nacional de Jujuy.', 'href' => '/noticias/jimmy-delgado-unju-argentina'],
            ['title_es' => 'Movilidad académica Programa Escala Docente (PED) de AUGM - Montevideo, Uruguay', 'title_en' => 'Academic mobility through AUGM Faculty Scale Program (PED) - Montevideo, Uruguay', 'date_es' => 'Nov 29, 2024', 'date_en' => 'Nov 29, 2024', 'published_at' => '2024-11-29', 'category_es' => 'Cooperación internacional', 'category_en' => 'International cooperation', 'excerpt_es' => 'El arquitecto Fabián Farfán Espinoza fortaleció vínculos académicos en la Facultad de Arquitectura, Diseño y Urbanismo de la Universidad de la República.', 'excerpt_en' => 'Architect Fabián Farfán Espinoza strengthened academic ties at the Faculty of Architecture, Design, and Urbanism of Universidad de la República.', 'href' => '/noticias/escala-docente-augm-montevideo-uruguay'],
            ['title_es' => 'Experiencia académica de innovación y colaboración en la UAA - Programa de Movilidad Académica Administrativa de CRISCOS, Paraguay', 'title_en' => 'Academic experience in innovation and collaboration at UAA - CRISCOS Administrative Academic Mobility Program, Paraguay', 'date_es' => 'Nov 20, 2024', 'date_en' => 'Nov 20, 2024', 'published_at' => '2024-11-20', 'category_es' => 'Movilidad administrativa', 'category_en' => 'Administrative mobility', 'excerpt_es' => 'José Limberg Camacho Acosta desarrolló una estancia académica en innovación en educación universitaria en la Universidad Autónoma de Asunción.', 'excerpt_en' => 'José Limberg Camacho Acosta completed an academic stay focused on innovation in higher education at Universidad Autónoma de Asunción.', 'href' => '/noticias/uaa-criscos-paraguay-innovacion-colaboracion'],
            ['title_es' => 'Participación de la UMSS en las 31° Jornadas de Jóvenes Investigadores de la AUGM', 'title_en' => 'UMSS participation in the 31st AUGM Young Researchers Conference', 'date_es' => 'Nov 13, 2024', 'date_en' => 'Nov 13, 2024', 'published_at' => '2024-11-13', 'category_es' => 'Investigación', 'category_en' => 'Research', 'excerpt_es' => 'Una delegación de jóvenes investigadores de la UMSS participó en el encuentro académico regional de AUGM realizado del 6 al 8 de noviembre.', 'excerpt_en' => 'A delegation of young UMSS researchers participated in the AUGM regional academic meeting held from November 6 to 8.', 'href' => '/noticias/umss-31-jornadas-jovenes-investigadores-augm'],
            ['title_es' => 'Movilidad administrativa en el marco del Programa CRISCOS: Patricia Ericka Espinoza García en la UNJBG, Perú', 'title_en' => 'Administrative mobility through the CRISCOS Program: Patricia Ericka Espinoza García at UNJBG, Peru', 'date_es' => 'Nov 8, 2024', 'date_en' => 'Nov 8, 2024', 'published_at' => '2024-11-08', 'category_es' => 'Movilidad administrativa', 'category_en' => 'Administrative mobility', 'excerpt_es' => 'Patricia Ericka Espinoza García realizó movilidad administrativa en la Universidad Nacional Jorge Basadre Grohmann de Perú.', 'excerpt_en' => 'Patricia Ericka Espinoza García completed an administrative mobility stay at Universidad Nacional Jorge Basadre Grohmann in Peru.', 'href' => '/noticias/patricia-espinoza-criscos-unjbg-peru'],
            ['title_es' => 'Estancia en el Programa Escala de Gestores y Administradores (PEGyA) de AUGM - Argentina', 'title_en' => 'Stay through the AUGM Managers and Administrators Scale Program (PEGyA) - Argentina', 'date_es' => 'Nov 8, 2024', 'date_en' => 'Nov 8, 2024', 'published_at' => '2024-11-08', 'category_es' => 'Gestión universitaria', 'category_en' => 'University management', 'excerpt_es' => 'Silvia del Pilar Arze Orellana, funcionaria de la UMSS, realizó una estancia en la Universidad Nacional de Córdoba, Argentina.', 'excerpt_en' => 'Silvia del Pilar Arze Orellana, UMSS staff member, completed a stay at Universidad Nacional de Córdoba in Argentina.', 'href' => '/noticias/pegya-augm-argentina-silvia-arze'],
            ['title_es' => 'Docente de la Universidad Nacional Jorge Basadre Grohmann de Perú visita la UMSS - Programa PMAA de CRISCOS', 'title_en' => 'Professor from Universidad Nacional Jorge Basadre Grohmann of Peru visits UMSS - CRISCOS PMAA Program', 'date_es' => 'Oct 22, 2024', 'date_en' => 'Oct 22, 2024', 'published_at' => '2024-10-22', 'category_es' => 'Visita académica', 'category_en' => 'Academic visit', 'excerpt_es' => 'La UMSS recibió al Dr. Juan Francisco Alberto Yábar Jibaya como parte del Programa de Movilidad Académica Administrativa de CRISCOS.', 'excerpt_en' => 'UMSS welcomed Dr. Juan Francisco Alberto Yábar Jibaya as part of the CRISCOS Administrative Academic Mobility Program.', 'href' => '/noticias/docente-unjbg-peru-visita-umss-criscos'],
            ['title_es' => 'Suscripción de convenio con el Colegio de Ingenieros Petroquímicos y Energías de Cochabamba', 'title_en' => 'Agreement signed with the College of Petrochemical and Energy Engineers of Cochabamba', 'date_es' => 'Oct 22, 2024', 'date_en' => 'Oct 22, 2024', 'published_at' => '2024-10-22', 'category_es' => 'Convenios', 'category_en' => 'Agreements', 'excerpt_es' => 'La UMSS y el CIPQEC firmaron un convenio interinstitucional para beneficiar a miembros y dependientes mediante cooperación académica.', 'excerpt_en' => 'UMSS and CIPQEC signed an interinstitutional agreement to benefit members and dependents through academic cooperation.', 'href' => '/noticias/convenio-cipqec-cochabamba'],
        ];
    }
}
