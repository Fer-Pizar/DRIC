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
use Illuminate\Support\Str;

class ProjectFundingPageSeeder extends Seeder
{
    public function run(): void
    {
        $parent = Page::query()->where('slug', 'proyectos')->firstOrFail();
        $page = Page::updateOrCreate(
            ['slug' => 'proyectos-apoyo-financiero'],
            [
                'parent_id' => $parent->id,
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => $parent->sort_order,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }

        $hero = $this->section($page, 'projects.funding.hero', 'project_funding_hero', 1, $languages, [
            'es' => ['title' => 'PROSUL Pepe Mujica', 'subtitle' => 'Convocatorias', 'summary' => 'Convocatoria MCTI/CNPq de Brasil para financiar investigación colaborativa entre instituciones de Brasil, América Latina y el Caribe.', 'body' => null],
            'en' => ['title' => 'PROSUL Pepe Mujica', 'subtitle' => 'Calls for proposals', 'summary' => 'MCTI/CNPq Brazil call to fund collaborative research among institutions in Brazil, Latin America, and the Caribbean.', 'body' => null],
        ]);

        $content = $this->section($page, 'projects.funding.content', 'project_funding_content', 2, $languages, [
            'es' => ['title' => 'Oportunidad de cooperación regional', 'subtitle' => null, 'summary' => implode("\n", $this->paragraphs('es')), 'body' => null],
            'en' => ['title' => 'Regional cooperation opportunity', 'subtitle' => null, 'summary' => implode("\n", $this->paragraphs('en')), 'body' => null],
        ]);

        $this->section($page, 'projects.funding.sidebar', 'project_funding_sidebar', 3, $languages, [
            'es' => ['title' => 'Áreas estratégicas', 'subtitle' => 'Convocatoria abierta', 'summary' => implode("\n", $this->areas('es')), 'body' => null],
            'en' => ['title' => 'Strategic areas', 'subtitle' => 'Open call', 'summary' => implode("\n", $this->areas('en')), 'body' => null],
        ]);

        $documents = $this->section($page, 'projects.funding.documents', 'project_funding_documents', 4, $languages, [
            'es' => ['title' => 'Documentos de la convocatoria', 'subtitle' => null, 'summary' => 'Acceda a las bases completas y a las preguntas frecuentes en español y portugués.', 'body' => null],
            'en' => ['title' => 'Call documents', 'subtitle' => null, 'summary' => 'Access the complete guidelines and frequently asked questions in Spanish and Portuguese.', 'body' => null],
        ]);

        $this->block($hero, 'projects.funding.back', 'action_label', 1, $languages, [
            'es' => ['title' => 'Volver a proyectos', 'summary' => null],
            'en' => ['title' => 'Back to projects', 'summary' => null],
        ]);

        $this->block($hero, 'projects.funding.metric.total', 'metric', 2, $languages, [
            'es' => ['title' => 'R$ 50.000.000', 'summary' => 'financiamiento total'],
            'en' => ['title' => 'R$ 50,000,000', 'summary' => 'total funding'],
        ]);

        $this->block($hero, 'projects.funding.metric.augm', 'metric', 3, $languages, [
            'es' => ['title' => '10%', 'summary' => 'reservado para proyectos con universidades AUGM'],
            'en' => ['title' => '10%', 'summary' => 'reserved for projects with AUGM universities'],
        ]);

        $this->block($content, 'projects.funding.official-info', 'external_link', 1, $languages, [
            'es' => ['title' => 'Más información oficial', 'summary' => null],
            'en' => ['title' => 'Official information', 'summary' => null],
        ], [
            'href' => 'https://www.gov.br/cnpq/pt-br/assuntos/noticias/cnpq-em-acao/prosul-pepe-mujica-vai-financiar-projetos-para-fortalecer-a-infraestrutura-cientifica-da-america-latina',
        ]);

        if (! ContentBlock::query()->where('section_id', $documents->id)->exists()) {
            foreach ($this->documents() as $index => $document) {
                $this->block($documents, 'projects.funding.document.'.Str::uuid()->toString(), 'funding_document', $index + 1, $languages, [
                    'es' => ['title' => $document['es'], 'summary' => null],
                    'en' => ['title' => $document['en'], 'summary' => null],
                ], ['href' => $document['href']]);
            }
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'PROSUL Pepe Mujica', 'menu_title' => 'Apoyo Financiero', 'subtitle' => 'Convocatorias', 'summary' => 'Convocatoria MCTI/CNPq de Brasil para financiar investigación colaborativa entre instituciones de Brasil, América Latina y el Caribe.', 'body' => null],
            'en' => ['title' => 'PROSUL Pepe Mujica', 'menu_title' => 'Financial Support', 'subtitle' => 'Calls for proposals', 'summary' => 'MCTI/CNPq Brazil call to fund collaborative research among institutions in Brazil, Latin America, and the Caribbean.', 'body' => null],
        ];
    }

    private function areas(string $locale): array
    {
        return $locale === 'en'
            ? ['Environment and sustainability', 'Food and agriculture', 'Energy and mining', 'Health', 'Information technologies', 'Humanities and social sciences']
            : ['Medio ambiente y sostenibilidad', 'Alimentación y agricultura', 'Energía y minería', 'Salud', 'Tecnologías de la información', 'Humanidades y ciencias sociales'];
    }

    private function paragraphs(string $locale): array
    {
        return $locale === 'en'
            ? [
                'The PROSUL Pepe Mujica Call (MCTI/CNPq - Brazil) is open to finance collaborative research projects between institutions in Brazil, Latin America, and the Caribbean.',
                'The Pepe Mujica Program focuses on creating thematic research networks among institutions in Latin America and the Caribbean, researcher mobility at different levels of training, and the joint development of strategic projects.',
                'It also includes actions to strengthen regional scientific infrastructure, stimulate technological innovation, and promote education and science communication.',
                'A particularly relevant point is that at least 10% of the total call funding is guaranteed for projects involving member universities of the Association of Universities Grupo Montevideo (AUGM), offering a concrete competitive advantage to institutions submitting proposals through this network.',
                'Academic units and interested researchers are invited to consider this opportunity and coordinate proposals with AUGM partners.',
            ]
            : [
                'Se encuentra abierta la Convocatoria PROSUL Pepe Mujica (MCTI/CNPq - Brasil), orientada a financiar proyectos de investigación colaborativa entre instituciones de Brasil y de América Latina y el Caribe.',
                'El Programa Pepe Mujica se centra en la formación de redes temáticas de investigación entre instituciones de América Latina y el Caribe, la movilidad de investigadores en diferentes niveles de formación y el desarrollo conjunto de proyectos estratégicos.',
                'También incluye acciones para fortalecer la infraestructura científica regional, estimular la innovación tecnológica y promover la educación y la difusión de la ciencia.',
                'Un aspecto especialmente relevante es que al menos el 10% del financiamiento total de la convocatoria está garantizado para proyectos que involucren a universidades miembro de la Asociación de Universidades Grupo Montevideo (AUGM), lo que representa una ventaja competitiva concreta para las instituciones que presenten propuestas en el marco de esta red.',
                'Se invita a las unidades académicas e investigadores interesados a considerar esta oportunidad y a articular propuestas con socios de la AUGM.',
            ];
    }

    private function documents(): array
    {
        return [
            ['es' => 'Convocatoria completa (portugués)', 'en' => 'Full call for proposals (Portuguese)', 'href' => 'https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQA31J1MFInGR4IYPtZGeRMnAVCVo8aVaAtsZDUskF4Ukbo?e=VycKEl'],
            ['es' => 'Convocatoria completa (español)', 'en' => 'Full call for proposals (Spanish)', 'href' => 'https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQApdgS7fwsFQot0es4VqMAmAQ1qqjSBKg04Df8QTsmbTfA?e=dnTpu4'],
            ['es' => 'Preguntas frecuentes (portugués)', 'en' => 'Frequently asked questions (Portuguese)', 'href' => 'https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQBCO_KLT2AbToIDcqJLBFH9AVQaCLfNpZDBzEZOgjC-7zo?e=HpfVp3'],
            ['es' => 'Preguntas frecuentes (español)', 'en' => 'Frequently asked questions (Spanish)', 'href' => 'https://miumssedu-my.sharepoint.com/:b:/g/personal/dric_mi_umss_edu/IQCXo57aZtlCT5cs4FLkRWP5AUnqFj-s1DH42KYiKfxjjio?e=KTwedo'],
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

        foreach ($translations as $locale => $values) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                ['title' => $values['title'], 'subtitle' => null, 'summary' => $values['summary'], 'body' => null]
            );
        }
    }
}
