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

class ScholarshipBecasPageSeeder extends Seeder
{
    public function run(): void
    {
        $parent = Page::where('slug', 'becas-movilidad')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'becas'],
            [
                'parent_id' => $parent?->id,
                'page_type' => 'scholarship_catalog',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => 1,
                'created_by' => null,
                'updated_by' => null,
            ]
        );

        $es = Language::where('code', 'es')->firstOrFail();
        $en = Language::where('code', 'en')->firstOrFail();

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $es->id],
            [
                'title' => 'Becas',
                'menu_title' => 'Becas',
                'subtitle' => 'Explora becas por destino',
                'summary' => 'Catalogo organizado de países, programas y organismos internacionales.',
                'body' => null,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $en->id],
            [
                'title' => 'Scholarships',
                'menu_title' => 'Scholarships',
                'subtitle' => 'Explore scholarships by destination',
                'summary' => 'Organized catalog of countries, programs and international organizations.',
                'body' => null,
            ]
        );

        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'scholarship.catalog'],
            [
                'section_type' => 'scholarship_catalog',
                'layout' => 'directory_grid',
                'settings' => ['editable' => true],
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        SectionTranslation::updateOrCreate(
            ['section_id' => $section->id, 'language_id' => $es->id],
            [
                'title' => 'Directorio alfabético',
                'subtitle' => 'Países, programas y organismos',
                'summary' => 'Cada registro puede convertirse en una ficha editable con convocatorias, requisitos, enlaces y PDFs.',
                'body' => null,
            ]
        );

        SectionTranslation::updateOrCreate(
            ['section_id' => $section->id, 'language_id' => $en->id],
            [
                'title' => 'Alphabetical directory',
                'subtitle' => 'Countries, programs and organizations',
                'summary' => 'Each record can become an editable profile with calls, requirements, links and PDFs.',
                'body' => null,
            ]
        );

        foreach ($this->catalogItems() as $index => $item) {
            $block = ContentBlock::updateOrCreate(
                ['section_id' => $section->id, 'link_url' => $item['link_url']],
                [
                    'block_type' => $item['type'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'data' => [
                        'slug' => $item['slug'],
                        'region_es' => $item['region_es'],
                        'region_en' => $item['region_en'],
                        'accent' => $item['accent'],
                        'parent_slug' => $item['parent_slug'] ?? null,
                        'opportunities' => $this->opportunitiesFor($item['slug']),
                    ],
                    'media_asset_id' => null,
                ]
            );

            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $es->id],
                [
                    'title' => $item['name_es'],
                    'subtitle' => $item['region_es'],
                    'summary' => $item['summary_es'],
                    'body' => null,
                ]
            );

            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $en->id],
                [
                    'title' => $item['name_en'],
                    'subtitle' => $item['region_en'],
                    'summary' => $item['summary_en'],
                    'body' => null,
                ]
            );
        }
    }

    private function catalogItems(): array
    {
        return [
            ['slug' => 'alemania', 'type' => 'country', 'name_es' => 'Alemania', 'name_en' => 'Germany', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas, movilidad y oportunidades académicas con instituciones alemanas.', 'summary_en' => 'Scholarships, mobility and academic opportunities with German institutions.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/alemania'],
            ['slug' => 'australia', 'type' => 'country', 'name_es' => 'Australia', 'name_en' => 'Australia', 'region_es' => 'Oceanía', 'region_en' => 'Oceanía', 'summary_es' => 'Programas académicos, investigación y convocatorias internacionales.', 'summary_en' => 'Academic programs, research and international calls.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/australia'],
            ['slug' => 'austria', 'type' => 'country', 'name_es' => 'Austria', 'name_en' => 'Austria', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Oportunidades de formación, intercambio y cooperación académica.', 'summary_en' => 'Training, exchange and academic cooperation opportunities.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/austria'],
            ['slug' => 'belgica', 'type' => 'country', 'name_es' => 'Bélgica', 'name_en' => 'Belgium', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Convocatorias europeas, cooperación universitaria y movilidad.', 'summary_en' => 'European calls, university cooperation and mobility.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/belgica'],
            ['slug' => 'brasil', 'type' => 'country', 'name_es' => 'Brasil', 'name_en' => 'Brazil', 'region_es' => 'América Latina', 'region_en' => 'Latin America', 'summary_es' => 'Programas regionales, redes académicas y cooperación sur-sur.', 'summary_en' => 'Regional programs, academic networks and south-south cooperation.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/brasil'],
            ['slug' => 'chile', 'type' => 'country', 'name_es' => 'Chile', 'name_en' => 'Chile', 'region_es' => 'América Latina', 'region_en' => 'Latin America', 'summary_es' => 'Movilidad regional, investigación conjunta y becas universitarias.', 'summary_en' => 'Regional mobility, joint research and university scholarships.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/chile'],
            ['slug' => 'china', 'type' => 'country', 'name_es' => 'China', 'name_en' => 'China', 'region_es' => 'Asia', 'region_en' => 'Asia', 'summary_es' => 'Becas gubernamentales, movilidad y oportunidades académicas en Asia.', 'summary_en' => 'Government scholarships, mobility and academic opportunities in Asia.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/china'],
            ['slug' => 'hong-kong', 'type' => 'country', 'name_es' => 'Hong Kong', 'name_en' => 'Hong Kong', 'region_es' => 'Asia', 'region_en' => 'Asia', 'summary_es' => 'Convocatorias y oportunidades específicas para Hong Kong.', 'summary_en' => 'Specific calls and opportunities for Hong Kong.', 'accent' => '#E30613', 'parent_slug' => 'china', 'link_url' => '/becas-movilidad/becas/hong-kong'],
            ['slug' => 'colombia', 'type' => 'country', 'name_es' => 'Colombia', 'name_en' => 'Colombia', 'region_es' => 'América Latina', 'region_en' => 'Latin America', 'summary_es' => 'Intercambio académico, redes universitarias y programas regionales.', 'summary_en' => 'Academic exchange, university networks and regional programs.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/colombia'],
            ['slug' => 'corea-del-sur', 'type' => 'country', 'name_es' => 'Corea del Sur', 'name_en' => 'South Korea', 'region_es' => 'Asia', 'region_en' => 'Asia', 'summary_es' => 'Becas, posgrados y movilidad académica con instituciones coreanas.', 'summary_en' => 'Scholarships, graduate studies and mobility with Korean institutions.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/corea-del-sur'],
            ['slug' => 'ecuador', 'type' => 'country', 'name_es' => 'Ecuador', 'name_en' => 'Ecuador', 'region_es' => 'América Latina', 'region_en' => 'Latin America', 'summary_es' => 'Cooperacion regional, intercambio y oportunidades académicas.', 'summary_en' => 'Regional cooperation, exchange and academic opportunities.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/ecuador'],
            ['slug' => 'espana', 'type' => 'country', 'name_es' => 'España', 'name_en' => 'Spain', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas de grado, posgrado, movilidad y cooperación universitaria.', 'summary_en' => 'Undergraduate, graduate, mobility and university cooperation scholarships.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/espana'],
            ['slug' => 'estados-unidos', 'type' => 'country', 'name_es' => 'Estados Unidos', 'name_en' => 'United States', 'region_es' => 'Norteamérica', 'region_en' => 'North America', 'summary_es' => 'Convocatorias, investigación, intercambio y programas de liderazgo.', 'summary_en' => 'Calls, research, exchange and leadership programs.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/estados-unidos'],
            ['slug' => 'francia', 'type' => 'country', 'name_es' => 'Francia', 'name_en' => 'France', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas, redes académicas y oportunidades de formación internacional.', 'summary_en' => 'Scholarships, academic networks and international training opportunities.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/francia'],
            ['slug' => 'holanda', 'type' => 'country', 'name_es' => 'Holanda', 'name_en' => 'Netherlands', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Programas de intercambio, becas y cooperación cientifica.', 'summary_en' => 'Exchange programs, scholarships and scientific cooperation.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/holanda'],
            ['slug' => 'irlanda', 'type' => 'country', 'name_es' => 'Irlanda', 'name_en' => 'Ireland', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Oportunidades académicas, posgrados y programas internacionales.', 'summary_en' => 'Academic opportunities, graduate studies and international programs.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/irlanda'],
            ['slug' => 'italia', 'type' => 'country', 'name_es' => 'Italia', 'name_en' => 'Italy', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas, intercambio cultural y cooperación académica internacional.', 'summary_en' => 'Scholarships, cultural exchange and international academic cooperation.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/italia'],
            ['slug' => 'japon', 'type' => 'country', 'name_es' => 'Japón', 'name_en' => 'Japan', 'region_es' => 'Asia', 'region_en' => 'Asia', 'summary_es' => 'Becas, investigación, tecnología y movilidad académica.', 'summary_en' => 'Scholarships, research, technology and academic mobility.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/japon'],
            ['slug' => 'mexico', 'type' => 'country', 'name_es' => 'México', 'name_en' => 'Mexico', 'region_es' => 'América Latina', 'region_en' => 'Latin America', 'summary_es' => 'Programas regionales, posgrados y redes de cooperación académica.', 'summary_en' => 'Regional programs, graduate studies and academic cooperation networks.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/mexico'],
            ['slug' => 'reino-unido', 'type' => 'country', 'name_es' => 'Reino Unido', 'name_en' => 'United Kingdom', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas de excelencia, posgrados y oportunidades internacionales.', 'summary_en' => 'Excellence scholarships, graduate studies and international opportunities.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/reino-unido'],
            ['slug' => 'suecia', 'type' => 'country', 'name_es' => 'Suecia', 'name_en' => 'Sweden', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Becas, sostenibilidad, investigación y movilidad académica.', 'summary_en' => 'Scholarships, sustainability, research and academic mobility.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/suecia'],
            ['slug' => 'suiza', 'type' => 'country', 'name_es' => 'Suiza', 'name_en' => 'Switzerland', 'region_es' => 'Europa', 'region_en' => 'Europe', 'summary_es' => 'Programas de investigación, movilidad y excelencia académica.', 'summary_en' => 'Research programs, mobility and academic excellence.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/suiza'],
            ['slug' => 'taiwan', 'type' => 'country', 'name_es' => 'Taiwán', 'name_en' => 'Taiwan', 'region_es' => 'Asia', 'region_en' => 'Asia', 'summary_es' => 'Becas, tecnología, idiomas y programas académicos.', 'summary_en' => 'Scholarships, technology, languages and academic programs.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/taiwan'],
            ['slug' => 'turquia', 'type' => 'country', 'name_es' => 'Turquía', 'name_en' => 'Turkey', 'region_es' => 'Europa / Asia', 'region_en' => 'Europe / Asia', 'summary_es' => 'Becas internacionales, movilidad y cooperación académica.', 'summary_en' => 'International scholarships, mobility and academic cooperation.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/turquia'],
            ['slug' => 'abe', 'type' => 'organization', 'name_es' => 'ABE', 'name_en' => 'ABE', 'region_es' => 'Programa internacional', 'region_en' => 'International program', 'summary_es' => 'Convocatorias y programas especiales vinculados a ABE.', 'summary_en' => 'Calls and special programs linked to ABE.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/abe'],
            ['slug' => 'banco-mundial', 'type' => 'organization', 'name_es' => 'Banco Mundial', 'name_en' => 'World Bank', 'region_es' => 'Organismo internacional', 'region_en' => 'International organization', 'summary_es' => 'Becas, investigación y oportunidades de desarrollo global.', 'summary_en' => 'Scholarships, research and global development opportunities.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/banco-mundial'],
            ['slug' => 'egpp', 'type' => 'organization', 'name_es' => 'EGPP', 'name_en' => 'EGPP', 'region_es' => 'Programa académico', 'region_en' => 'Academic program', 'summary_es' => 'Información y convocatorias administradas por programa.', 'summary_en' => 'Program-managed information and calls.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/egpp'],
            ['slug' => 'union-europea', 'type' => 'organization', 'name_es' => 'Unión Europea', 'name_en' => 'European Union', 'region_es' => 'Cooperacion europea', 'region_en' => 'European cooperation', 'summary_es' => 'Becas, movilidad, proyectos y cooperación internacional europea.', 'summary_en' => 'Scholarships, mobility, projects and European international cooperation.', 'accent' => '#003770', 'link_url' => '/becas-movilidad/becas/union-europea'],
            ['slug' => 'otros', 'type' => 'organization', 'name_es' => 'Otros', 'name_en' => 'Others', 'region_es' => 'Más oportunidades', 'region_en' => 'More opportunities', 'summary_es' => 'Otras convocatorias internacionales que no pertenecen a un pais especifico.', 'summary_en' => 'Other international calls that do not belong to a specific country.', 'accent' => '#E30613', 'link_url' => '/becas-movilidad/becas/otros'],
        ];
    }

    private function opportunitiesFor(string $slug): array
    {
        if ($slug !== 'alemania') {
            return [];
        }

        return [
            [
                'slug' => 'daad',
                'title_es' => 'Servicio Alemán de Intercambio Académico (DAAD).',
                'title_en' => 'German Academic Exchange Service (DAAD).',
                'body_es' => 'El DAAD es una de las principales instituciones alemanas de cooperación académica internacional. Sus programas reúnen becas, estancias de investigación, estudios de posgrado, cursos especializados y oportunidades de movilidad para estudiantes, graduados, docentes e investigadores interesados en fortalecer su formación en Alemania.',
                'body_en' => 'DAAD is one of Germany\'s leading institutions for international academic cooperation. Its programs bring together scholarships, research stays, postgraduate studies, specialized courses and mobility opportunities for students, graduates, faculty and researchers interested in strengthening their academic path in Germany.',
                'href' => 'https://www.daad.de/en/studying-in-germany/scholarships/',
                'link_label_es' => 'Ver sitio oficial DAAD',
                'link_label_en' => 'Open DAAD official site',
            ],
            [
                'slug' => 'kaad',
                'title_es' => 'Programa de becas KAAD',
                'title_en' => 'KAAD scholarship programme',
                'body_es' => 'El KAAD ofrece programas de becas orientados principalmente a estudios de posgrado, doctorado, investigación y formación académica en Alemania. Sus convocatorias valoran el rendimiento académico, la experiencia profesional, el compromiso social y la vinculación del proyecto de estudios con el desarrollo de la región de origen.',
                'body_en' => 'KAAD offers scholarship programmes mainly focused on postgraduate studies, doctoral studies, research and academic training in Germany. Its calls value academic performance, professional experience, social commitment and the connection between the study project and the development of the applicant\'s home region.',
                'href' => 'https://www.kaad.de/en/stipendien/seite',
                'link_label_es' => 'Ver sitio oficial KAAD',
                'link_label_en' => 'Open KAAD official site',
            ],
        ];
    }
}
