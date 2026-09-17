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

class InternationalizationPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'internacionalizacion')->firstOrFail();

        $page->update([
            'status' => 'published',
            'published_at' => $page->published_at ?? now(),
        ]);

        if ($page->sections()->where('section_key', 'internationalization.hero')->exists()) {
            return;
        }

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $this->section($page, 'internationalization.hero', 'internationalization_hero', 1, $languages, [
            'es' => [
                'title' => 'Internacionalización',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'La internacionalización fortalece la formación académica, la cooperación científica y la vinculación institucional de la Universidad Mayor de San Simón con redes, universidades y organismos del mundo.',
                'body' => null,
            ],
            'en' => [
                'title' => 'Internationalization',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'Internationalization strengthens academic training, scientific cooperation and institutional engagement between Universidad Mayor de San Simón and global networks, universities and organizations.',
                'body' => null,
            ],
        ]);

        $this->section($page, 'internationalization.detail', 'internationalization_detail', 2, $languages, [
            'es' => [
                'title' => 'Internacionalización',
                'subtitle' => null,
                'summary' => null,
                'body' => implode("\n\n", $this->detailParagraphs('es')),
            ],
            'en' => [
                'title' => 'Internationalization',
                'subtitle' => null,
                'summary' => null,
                'body' => implode("\n\n", $this->detailParagraphs('en')),
            ],
        ]);

        $workAreas = $this->section($page, 'internationalization.work_areas', 'internationalization_work_areas', 3, $languages, [
            'es' => [
                'title' => 'Una universidad conectada con oportunidades globales',
                'subtitle' => 'Ejes de trabajo',
                'summary' => 'Este espacio reúne las líneas de acción que impulsan la presencia internacional de la UMSS y facilitan nuevas oportunidades para estudiantes, docentes, investigadores y unidades académicas.',
                'body' => null,
            ],
            'en' => [
                'title' => 'A university connected to global opportunities',
                'subtitle' => 'Work areas',
                'summary' => 'This space brings together the lines of action that expand UMSS international presence and create new opportunities for students, faculty, researchers and academic units.',
                'body' => null,
            ],
        ]);

        foreach ($this->cards() as $index => $card) {
            $this->block($workAreas, "internationalization.card.{$index}", 'internationalization_card', $index, $languages, [
                'es' => ['title' => $card['title_es'], 'summary' => $card['text_es']],
                'en' => ['title' => $card['title_en'], 'summary' => $card['text_en']],
            ], ['icon' => $card['icon']]);
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => [
                'title' => 'Internacionalización',
                'menu_title' => 'Internacionalización',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'La internacionalización fortalece la formación académica, la cooperación científica y la vinculación institucional de la Universidad Mayor de San Simón con redes, universidades y organismos del mundo.',
                'body' => null,
            ],
            'en' => [
                'title' => 'Internationalization',
                'menu_title' => 'Internationalization',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'Internationalization strengthens academic training, scientific cooperation and institutional engagement between Universidad Mayor de San Simón and global networks, universities and organizations.',
                'body' => null,
            ],
        ];
    }

    private function detailParagraphs(string $locale): array
    {
        return [
            'es' => [
                'La Internacionalización de la Educación Superior tiene como propósito mejorar los procesos de formación, investigación e interacción social en las universidades, contribuyendo de esta manera a la sociedad con profesionales/ciudadanos preparados para enfrentar los cambios y desafíos, a escala no solo Local sino también Regional y Mundial.',
                'Se cuenta con una propuesta de un Plan de Internacionalización que tiene como objetivo: Fortalecer los procesos y acciones de internacionalización que se desarrollan en la UMSS, desde una perspectiva endógena, colaborativa, integral e interregional, propiciando su incorporación institucional, transversal y contextualizada en las funciones formativas, investigativas y de interrelación y servicio a la comunidad; con políticas, estrategias y acciones sistematizadas en un Plan de Internacionalización Universitario concertado y amplio y, que responda a la nueva realidad generada como efecto de la pandemia en nuestro país y en el planeta.',
                'Actualmente la Dirección de Relaciones Internacionales y Convenios, tiene el objetivo de generar un proceso de apropiación del indicado Plan de parte de la comunidad sansimoniana, de manera que se consiga su fortalecimiento a través de la definición de políticas y estrategias institucionales.',
                'En el contexto generado por la pandemia del covid-19, las instituciones de Educación Superior debemos trabajar en transformaciones y cambios reales que mejoren la calidad de la formación para responder a nuestro encargo social. La Internacionalización es un instrumento que posibilita encaminarnos hacia la calidad en la formación de competencias para el desempeño de los profesionales en todos los ámbitos del planeta.',
                'Se plantea como una necesidad el implementar programas y estrategias apoyadas en el uso de la conectividad digital, para el desarrollo de la internacionalización en casa, la movilidad virtual, la investigación conjunta con socios de la Región y del mundo, el desarrollo de proyectos conjuntos, el intercambio de conocimientos y experiencias en redes, eventos colaborativos entre universidades y países, entre otras acciones.',
            ],
            'en' => [
                'The internationalization of higher education aims to improve training, research, and social interaction processes in universities, contributing to society with professionals and citizens prepared to face changes and challenges at local, regional, and global scales.',
                'There is a proposal for an Internationalization Plan whose objective is to strengthen the internationalization processes and actions developed at UMSS from an endogenous, collaborative, comprehensive, and interregional perspective, promoting their institutional, cross-cutting, and contextualized incorporation into training, research, interrelation, and community service functions.',
                'Currently, the Directorate of International Relations and Agreements seeks to generate a process through which the San Simon community takes ownership of this Plan, so it can be strengthened through the definition of institutional policies and strategies.',
                'In the context generated by the covid-19 pandemic, higher education institutions must work on real transformations and changes that improve the quality of education in response to our social mission. Internationalization is an instrument that allows us to move toward quality in the development of competencies for professional performance in every sphere of the world.',
                'It is necessary to implement programs and strategies supported by digital connectivity for the development of internationalization at home, virtual mobility, joint research with partners in the region and around the world, joint projects, knowledge and experience exchange through networks, and collaborative events between universities and countries, among other actions.',
            ],
        ][$locale] ?? [];
    }

    private function cards(): array
    {
        return [
            1 => ['icon' => 'public', 'title_es' => 'Cooperación académica', 'title_en' => 'Academic cooperation', 'text_es' => 'Promovemos vínculos con instituciones nacionales e internacionales para fortalecer proyectos, redes y programas conjuntos.', 'text_en' => 'We promote relationships with national and international institutions to strengthen projects, networks and joint programs.'],
            2 => ['icon' => 'school', 'title_es' => 'Movilidad y formación', 'title_en' => 'Mobility and training', 'text_es' => 'Impulsamos oportunidades de intercambio, becas, pasantías y experiencias internacionales para la comunidad universitaria.', 'text_en' => 'We support exchange opportunities, scholarships, internships and international experiences for the university community.'],
            3 => ['icon' => 'groups', 'title_es' => 'Proyección institucional', 'title_en' => 'Institutional projection', 'text_es' => 'Acompañamos la participación de la UMSS en espacios globales de colaboración, innovación y desarrollo académico.', 'text_en' => 'We accompany UMSS participation in global spaces for collaboration, innovation and academic development.'],
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
                    'subtitle' => null,
                    'summary' => $translations[$locale]['summary'] ?? null,
                    'body' => null,
                    'cta_label' => null,
                ]
            );
        }
    }
}
