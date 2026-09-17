<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectFundingContentController extends Controller
{
    private const PAGE_SLUG = 'proyectos-apoyo-financiero';
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(): View
    {
        $this->authorizeFundingAccess();
        $page = $this->ensurePage();

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.project-funding-content', [
            'page' => $page,
            'projectPage' => Page::query()->where('slug', 'proyectos')->firstOrFail(),
            'content' => $this->formContent($page),
            'documents' => $this->documents($page),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorizeFundingAccess();
        $page = $this->ensurePage();
        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $documents = $this->validatedDocuments($request);

        DB::transaction(function () use ($request, $validated, $documents, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['subtitle'],
                        'body' => null,
                    ]
                );
            }

            $hero = $this->upsertSection($page, 'projects.funding.hero', 'project_funding_hero', 1);
            $content = $this->upsertSection($page, 'projects.funding.content', 'project_funding_content', 2);
            $sidebar = $this->upsertSection($page, 'projects.funding.sidebar', 'project_funding_sidebar', 3);
            $documentsSection = $this->upsertSection($page, 'projects.funding.documents', 'project_funding_documents', 4);

            foreach (['es', 'en'] as $locale) {
                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['subtitle'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $content->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['section_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['paragraphs'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $sidebar->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['areas_title'],
                        'subtitle' => $validated[$locale]['open_label'],
                        'summary' => $validated[$locale]['areas'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $documentsSection->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['docs_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['docs_intro'],
                        'body' => null,
                    ]
                );
            }

            $this->upsertBlock($hero, 'projects.funding.metric.total', 'metric', 2, $languages, [
                'es' => ['title' => $validated['es']['total'], 'summary' => $validated['es']['total_label']],
                'en' => ['title' => $validated['en']['total'], 'summary' => $validated['en']['total_label']],
            ]);

            $this->upsertBlock($hero, 'projects.funding.metric.augm', 'metric', 3, $languages, [
                'es' => ['title' => $validated['es']['augm'], 'summary' => $validated['es']['augm_label']],
                'en' => ['title' => $validated['en']['augm'], 'summary' => $validated['en']['augm_label']],
            ]);

            $this->upsertBlock($content, 'projects.funding.official-info', 'external_link', 1, $languages, [
                'es' => ['title' => $validated['es']['more_info'], 'summary' => null],
                'en' => ['title' => $validated['en']['more_info'], 'summary' => null],
            ], ['href' => $validated['more_info_url']]);

            $this->syncDocuments($documentsSection, $documents, $languages);
        });

        return redirect()
            ->route('admin.project-funding.edit')
            ->with('success', 'El contenido de Apoyo Financiero fue actualizado correctamente.');
    }

    private function ensurePage(): Page
    {
        $parent = Page::query()->where('slug', 'proyectos')->firstOrFail();

        return Page::updateOrCreate(
            ['slug' => self::PAGE_SLUG],
            [
                'parent_id' => $parent->id,
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => $parent->sort_order,
            ]
        );
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.eyebrow"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.title"] = ['required', 'string', 'max:180'];
            $localized["{$locale}.subtitle"] = ['required', 'string', 'max:900'];
            $localized["{$locale}.open_label"] = ['required', 'string', 'max:100'];
            $localized["{$locale}.total"] = ['required', 'string', 'max:80'];
            $localized["{$locale}.total_label"] = ['required', 'string', 'max:160'];
            $localized["{$locale}.augm"] = ['required', 'string', 'max:80'];
            $localized["{$locale}.augm_label"] = ['required', 'string', 'max:180'];
            $localized["{$locale}.section_title"] = ['required', 'string', 'max:180'];
            $localized["{$locale}.paragraphs"] = ['required', 'string', 'max:5000'];
            $localized["{$locale}.areas_title"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.areas"] = ['required', 'string', 'max:1600'];
            $localized["{$locale}.docs_title"] = ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.docs_intro"] = ['required', 'string', 'max:500'];
            $localized["{$locale}.more_info"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
        }

        return array_merge($localized, [
            'more_info_url' => ['required', 'url', 'max:900'],
        ]);
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function validatedDocuments(Request $request): array
    {
        $rows = collect($request->input('documents', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['url'] ?? null))
            ->values()
            ->all();

        $validated = Validator::make(
            ['documents' => $rows],
            [
                'documents' => ['array'],
                'documents.*.id' => ['nullable', 'integer'],
                'documents.*.title_es' => ['required', 'string', 'max:600'],
                'documents.*.title_en' => ['nullable', 'string', 'max:600'],
                'documents.*.url' => ['required', 'url', 'max:900'],
            ],
            [
                'documents.*.title_es.required' => 'Escribe el texto visible del documento.',
                'documents.*.title_es.max' => 'El texto del documento es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.title_en.max' => 'El texto en inglés es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.url.required' => 'Ingresa la URL del documento.',
                'documents.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf',
                'documents.*.url.max' => 'La URL es demasiado larga. Usa máximo 900 caracteres.',
            ]
        )->validate();

        return collect($validated['documents'] ?? [])
            ->map(fn ($row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'title_es' => trim($row['title_es']),
                'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                'url' => trim($row['url']),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'projects.funding.hero', 'es', 'subtitle', 'Convocatorias'),
                'title' => $this->pageValue($page, 'es', 'title', 'PROSUL Pepe Mujica'),
                'subtitle' => $this->sectionValue($page, 'projects.funding.hero', 'es', 'summary', 'Convocatoria MCTI/CNPq de Brasil para financiar investigación colaborativa entre instituciones de Brasil, América Latina y el Caribe.'),
                'open_label' => $this->sectionValue($page, 'projects.funding.sidebar', 'es', 'subtitle', 'Convocatoria abierta'),
                'total' => $this->blockValue($page, 'projects.funding.metric.total', 'es', 'title', 'R$ 50.000.000'),
                'total_label' => $this->blockValue($page, 'projects.funding.metric.total', 'es', 'summary', 'financiamiento total'),
                'augm' => $this->blockValue($page, 'projects.funding.metric.augm', 'es', 'title', '10%'),
                'augm_label' => $this->blockValue($page, 'projects.funding.metric.augm', 'es', 'summary', 'reservado para proyectos con universidades AUGM'),
                'section_title' => $this->sectionValue($page, 'projects.funding.content', 'es', 'title', 'Oportunidad de cooperación regional'),
                'paragraphs' => $this->sectionValue($page, 'projects.funding.content', 'es', 'summary', implode("\n", $this->fallbackParagraphs('es'))),
                'areas_title' => $this->sectionValue($page, 'projects.funding.sidebar', 'es', 'title', 'Áreas estratégicas'),
                'areas' => $this->sectionValue($page, 'projects.funding.sidebar', 'es', 'summary', implode("\n", $this->fallbackAreas('es'))),
                'docs_title' => $this->sectionValue($page, 'projects.funding.documents', 'es', 'title', 'Documentos de la convocatoria'),
                'docs_intro' => $this->sectionValue($page, 'projects.funding.documents', 'es', 'summary', 'Acceda a las bases completas y a las preguntas frecuentes en español y portugués.'),
                'more_info' => $this->blockValue($page, 'projects.funding.official-info', 'es', 'title', 'Más información oficial'),
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'projects.funding.hero', 'en', 'subtitle', 'Calls for proposals'),
                'title' => $this->pageValue($page, 'en', 'title', 'PROSUL Pepe Mujica'),
                'subtitle' => $this->sectionValue($page, 'projects.funding.hero', 'en', 'summary', 'MCTI/CNPq Brazil call to fund collaborative research among institutions in Brazil, Latin America, and the Caribbean.'),
                'open_label' => $this->sectionValue($page, 'projects.funding.sidebar', 'en', 'subtitle', 'Open call'),
                'total' => $this->blockValue($page, 'projects.funding.metric.total', 'en', 'title', 'R$ 50,000,000'),
                'total_label' => $this->blockValue($page, 'projects.funding.metric.total', 'en', 'summary', 'total funding'),
                'augm' => $this->blockValue($page, 'projects.funding.metric.augm', 'en', 'title', '10%'),
                'augm_label' => $this->blockValue($page, 'projects.funding.metric.augm', 'en', 'summary', 'reserved for projects with AUGM universities'),
                'section_title' => $this->sectionValue($page, 'projects.funding.content', 'en', 'title', 'Regional cooperation opportunity'),
                'paragraphs' => $this->sectionValue($page, 'projects.funding.content', 'en', 'summary', implode("\n", $this->fallbackParagraphs('en'))),
                'areas_title' => $this->sectionValue($page, 'projects.funding.sidebar', 'en', 'title', 'Strategic areas'),
                'areas' => $this->sectionValue($page, 'projects.funding.sidebar', 'en', 'summary', implode("\n", $this->fallbackAreas('en'))),
                'docs_title' => $this->sectionValue($page, 'projects.funding.documents', 'en', 'title', 'Call documents'),
                'docs_intro' => $this->sectionValue($page, 'projects.funding.documents', 'en', 'summary', 'Access the complete guidelines and frequently asked questions in Spanish and Portuguese.'),
                'more_info' => $this->blockValue($page, 'projects.funding.official-info', 'en', 'title', 'Official information'),
            ],
            'more_info_url' => $this->blockData($page, 'projects.funding.official-info', 'href', 'https://www.gov.br/cnpq/pt-br/assuntos/noticias/cnpq-em-acao/prosul-pepe-mujica-vai-financiar-projetos-para-fortalecer-a-infraestrutura-cientifica-da-america-latina'),
        ];
    }

    private function documents(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'projects.funding.documents');

        return ($section?->contentBlocks ?? collect())
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'url' => is_string($block->data['href'] ?? null) ? $block->data['href'] : '',
            ])
            ->all();
    }

    private function syncDocuments(Section $section, array $documents, $languages): void
    {
        $keptIds = [];

        foreach ($documents as $index => $document) {
            $block = $document['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $document['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'projects.funding.document.'.Str::uuid()->toString(),
                ]);
            }

            $block->fill([
                'block_type' => 'funding_document',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => ['href' => $document['url']],
            ]);
            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $document['title_es'] : $document['title_en'],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): ContentBlock
    {
        $block = ContentBlock::updateOrCreate(
            ['section_id' => $section->id, 'link_url' => $key],
            ['block_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'data' => $data]
        );

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'],
                    'subtitle' => null,
                    'summary' => $translations[$locale]['summary'],
                    'body' => null,
                ]
            );
        }

        return $block;
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $this->block($page, $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockData(Page $page, string $key, string $dataKey, string $fallback): string
    {
        $value = $this->block($page, $key)?->data[$dataKey] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $fallback;
    }

    private function block(Page $page, string $key): ?ContentBlock
    {
        return $page->sections->flatMap(fn (Section $section) => $section->contentBlocks)->firstWhere('link_url', $key);
    }

    private function fallbackAreas(string $locale): array
    {
        return $locale === 'en'
            ? ['Environment and sustainability', 'Food and agriculture', 'Energy and mining', 'Health', 'Information technologies', 'Humanities and social sciences']
            : ['Medio ambiente y sostenibilidad', 'Alimentación y agricultura', 'Energía y minería', 'Salud', 'Tecnologías de la información', 'Humanidades y ciencias sociales'];
    }

    private function fallbackParagraphs(string $locale): array
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

    private function authorizeFundingAccess(): void
    {
        $projectPage = Page::query()->where('slug', 'proyectos')->firstOrFail();

        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $projectPage), 403, 'No tienes permiso para editar Proyectos.');
    }
}
