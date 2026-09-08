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

class ScholarshipBecasContentController extends Controller
{
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';
    private const TYPE_OPTIONS = ['country', 'organization'];

    public function edit(Page $page): View
    {
        $this->authorizeScholarshipAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.scholarship-becas-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'countries' => $this->items($page, 'country'),
            'organizations' => $this->items($page, 'organization'),
            'hubPage' => Page::query()->where('slug', 'becas-movilidad')->first(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeScholarshipAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $countries = $this->validatedItems($request, 'countries', 'country');
        $organizations = $this->validatedItems($request, 'organizations', 'organization');

        DB::transaction(function () use ($request, $validated, $countries, $organizations, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $countriesSection = $this->upsertSection($page, 'scholarship.catalog', 'scholarship_catalog', 1);
            $organizationsSection = $this->upsertSection($page, 'scholarship.organizations', 'scholarship_organizations', 2);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['badge'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $countriesSection->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['countries_title'],
                        'subtitle' => $validated[$locale]['countries_badge'],
                        'summary' => null,
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $organizationsSection->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['organizations_title'],
                        'subtitle' => $validated[$locale]['organizations_badge'],
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }

            $this->syncItems($countriesSection, $organizationsSection, $countries, 'country', $languages);
            $this->syncItems($organizationsSection, $countriesSection, $organizations, 'organization', $languages);
        });

        return redirect()
            ->route('admin.pages.scholarship-becas.edit', $page)
            ->with('success', 'El contenido de Becas fue actualizado correctamente.');
    }

    public function editDetail(ContentBlock $block): View
    {
        $page = $this->authorizeScholarshipBlockAccess($block);

        $block->loadMissing(['translations.language']);

        return view('admin.pages.scholarship-becas-detail', [
            'page' => $page,
            'block' => $block,
            'name' => [
                'es' => $block->translations->firstWhere('language.code', 'es')?->title ?? 'Tarjeta de beca',
                'en' => $block->translations->firstWhere('language.code', 'en')?->title ?? 'Scholarship card',
            ],
            'items' => old('opportunities', $this->detailItems($block)),
        ]);
    }

    public function updateDetail(Request $request, ContentBlock $block): RedirectResponse
    {
        $this->authorizeScholarshipBlockAccess($block);

        $opportunities = $this->validatedDetailItems($request);

        $data = $block->data ?? [];
        $data['opportunities'] = $opportunities;
        $data['detail_edited'] = true;
        $block->forceFill(['data' => $data])->save();

        return redirect()
            ->route('admin.scholarship-items.detail.edit', $block)
            ->with('success', 'El detalle de la tarjeta fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.badge"] = ['required', 'string', 'max:100'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:900'];
            $rules["{$locale}.countries_badge"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.countries_title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.organizations_badge"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.organizations_title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://www.umss.edu.bo',
        ];
    }

    private function validatedDetailItems(Request $request): array
    {
        $rows = collect($request->input('opportunities', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['content_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['content_en'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['opportunities' => $rows],
            [
                'opportunities' => ['array'],
                'opportunities.*.id' => ['nullable', 'string', 'max:80'],
                'opportunities.*.title_es' => ['required', 'string', 'max:220'],
                'opportunities.*.title_en' => ['nullable', 'string', 'max:220'],
                'opportunities.*.content_es' => ['nullable', 'string', 'max:20000'],
                'opportunities.*.content_en' => ['nullable', 'string', 'max:20000'],
                'opportunities.*.body_es' => ['nullable', 'string', 'max:12000'],
                'opportunities.*.body_en' => ['nullable', 'string', 'max:12000'],
                'opportunities.*.bullets_es' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.bullets_en' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.raw_sections' => ['nullable', 'string', 'max:70000'],
                'opportunities.*.original_content_es' => ['nullable', 'string', 'max:20000'],
                'opportunities.*.original_content_en' => ['nullable', 'string', 'max:20000'],
                'opportunities.*.links' => ['nullable', 'array'],
                'opportunities.*.links.*.label_es' => ['nullable', 'string', 'max:160'],
                'opportunities.*.links.*.label_en' => ['nullable', 'string', 'max:160'],
                'opportunities.*.links.*.href' => ['nullable', 'string', 'max:900'],
            ],
            [
                'opportunities.*.title_es.required' => 'Escribe el título del contenido en español.',
                'opportunities.*.max' => 'Este campo supera el tamaño permitido.',
                'opportunities.*.links.*.max' => 'Este enlace supera el tamaño permitido.',
            ]
        );

        return collect($validator->validate()['opportunities'] ?? [])
            ->map(function (array $row): array {
                $titleEs = trim($row['title_es']);
                $titleEn = trim($row['title_en'] ?? '') ?: $titleEs;
                $contentEs = trim($row['content_es'] ?? $this->legacyContent($row['body_es'] ?? '', $row['bullets_es'] ?? ''));
                $contentEn = trim($row['content_en'] ?? $this->legacyContent($row['body_en'] ?? '', $row['bullets_en'] ?? '')) ?: $contentEs;
                $links = $this->validatedLinks($row['links'] ?? []);
                $preservedSections = $this->decodeRawSections($row['raw_sections'] ?? '');

                $contentSections = $this->canPreserveSections($row, $preservedSections)
                    ? $preservedSections
                    : $this->smartContentSections($contentEs, $contentEn);

                $firstLink = $links[0] ?? [
                    'href' => '#',
                    'label' => ['es' => 'Ver enlace', 'en' => 'Open link'],
                ];

                return [
                    'id' => $row['id'] ?? (string) Str::uuid(),
                    'slug' => Str::slug($titleEs) ?: (string) Str::uuid(),
                    'title' => ['es' => $titleEs, 'en' => $titleEn],
                    'body' => ['es' => $this->plainParagraphBody($contentSections, 'es'), 'en' => $this->plainParagraphBody($contentSections, 'en')],
                    'href' => $firstLink['href'],
                    'linkLabel' => $firstLink['label'],
                    'links' => $links,
                    'contentSections' => $contentSections,
                ];
            })
            ->values()
            ->all();
    }

    private function validatedItems(Request $request, string $key, string $type): array
    {
        $rows = collect($request->input($key, []))
            ->filter(fn ($row) => filled($row['name_es'] ?? null) || filled($row['name_en'] ?? null) || filled($row['url'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            [$key => $rows],
            [
                "{$key}" => ['array'],
                "{$key}.*.id" => ['nullable', 'integer'],
                "{$key}.*.name_es" => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX],
                "{$key}.*.name_en" => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX],
                "{$key}.*.region_es" => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
                "{$key}.*.region_en" => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
                "{$key}.*.summary_es" => ['required', 'string', 'max:700'],
                "{$key}.*.summary_en" => ['required', 'string', 'max:700'],
                "{$key}.*.url" => ['nullable', 'string', 'max:500'],
            ],
            [
                "{$key}.*.name_es.required" => 'Escribe el nombre en español.',
                "{$key}.*.name_en.required" => 'Escribe el nombre en inglés.',
                "{$key}.*.region_es.required" => 'Escribe la categoría en español.',
                "{$key}.*.region_en.required" => 'Escribe la categoría en inglés.',
                "{$key}.*.summary_es.required" => 'Escribe la descripción en español.',
                "{$key}.*.summary_en.required" => 'Escribe la descripción en inglés.',
                "{$key}.*.regex" => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            ]
        );

        return collect($validator->validate()[$key] ?? [])
            ->map(fn ($row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'type' => $type,
                'name_es' => trim($row['name_es']),
                'name_en' => trim($row['name_en']),
                'region_es' => trim($row['region_es']),
                'region_en' => trim($row['region_en']),
                'summary_es' => trim($row['summary_es']),
                'summary_en' => trim($row['summary_en']),
                'url' => trim($row['url'] ?? ''),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'badge' => $this->pageValue($page, 'es', 'subtitle', 'Convocatoria de becas'),
                'title' => $this->pageValue($page, 'es', 'title', 'Explora becas por destino'),
                'intro' => $this->pageValue($page, 'es', 'summary', 'Un catálogo claro y organizado de países y programas internacionales.'),
                'countries_badge' => $this->sectionValue($page, 'scholarship.catalog', 'es', 'subtitle', 'Países'),
                'countries_title' => $this->sectionValue($page, 'scholarship.catalog', 'es', 'title', 'Programas Internacionales'),
                'organizations_badge' => $this->sectionValue($page, 'scholarship.organizations', 'es', 'subtitle', 'Programas y organismos'),
                'organizations_title' => $this->sectionValue($page, 'scholarship.organizations', 'es', 'title', 'Otros canales de becas'),
            ],
            'en' => [
                'badge' => $this->pageValue($page, 'en', 'subtitle', 'Scholarship calls'),
                'title' => $this->pageValue($page, 'en', 'title', 'Explore scholarships by destination'),
                'intro' => $this->pageValue($page, 'en', 'summary', 'A clear, organized catalog of countries and international programs.'),
                'countries_badge' => $this->sectionValue($page, 'scholarship.catalog', 'en', 'subtitle', 'Countries'),
                'countries_title' => $this->sectionValue($page, 'scholarship.catalog', 'en', 'title', 'International Programs'),
                'organizations_badge' => $this->sectionValue($page, 'scholarship.organizations', 'en', 'subtitle', 'Programs and organizations'),
                'organizations_title' => $this->sectionValue($page, 'scholarship.organizations', 'en', 'title', 'Other scholarship channels'),
            ],
        ];
    }

    private function items(Page $page, string $type): array
    {
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->where('block_type', $type)
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'name_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'name_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'region_es' => $block->data['region_es'] ?? ($block->translations->firstWhere('language.code', 'es')?->subtitle ?? ''),
                'region_en' => $block->data['region_en'] ?? ($block->translations->firstWhere('language.code', 'en')?->subtitle ?? ''),
                'summary_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'summary_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
                'url' => $block->data['href'] ?? ($block->link_url ?? ''),
            ])
            ->all();
    }

    private function detailItems(ContentBlock $block): array
    {
        return collect($block->data['opportunities'] ?? [])
            ->map(function (array $item): array {
                $sections = $item['contentSections'] ?? $item['content_sections'] ?? [];
                $links = $item['links'] ?? [];
                $legacyHref = $item['href'] ?? null;
                $legacyLabel = $item['linkLabel'] ?? $item['link_label'] ?? null;

                if ($links === [] && filled($legacyHref)) {
                    $links[] = [
                        'href' => $legacyHref,
                        'label' => [
                            'es' => data_get($legacyLabel, 'es', 'Ver enlace'),
                            'en' => data_get($legacyLabel, 'en', data_get($legacyLabel, 'es', 'Open link')),
                        ],
                    ];
                }

                $contentEs = $this->smartContentFromSections($sections, 'es') ?: data_get($item, 'body.es', $item['body_es'] ?? '');
                $contentEn = $this->smartContentFromSections($sections, 'en') ?: data_get($item, 'body.en', $item['body_en'] ?? '');

                return [
                    'id' => $item['id'] ?? $item['slug'] ?? (string) Str::uuid(),
                    'title_es' => data_get($item, 'title.es', $item['title_es'] ?? ''),
                    'title_en' => data_get($item, 'title.en', $item['title_en'] ?? data_get($item, 'title.es', '')),
                    'content_es' => $contentEs,
                    'content_en' => $contentEn,
                    'raw_sections' => $this->encodeRawSections($sections),
                    'original_content_es' => $contentEs,
                    'original_content_en' => $contentEn,
                    'links' => collect($links)
                        ->map(fn ($link) => [
                            'label_es' => data_get($link, 'label.es', $link['label_es'] ?? ''),
                            'label_en' => data_get($link, 'label.en', $link['label_en'] ?? data_get($link, 'label.es', '')),
                            'href' => $link['href'] ?? '',
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->values()
            ->all();
    }

    private function paragraphsFromSections(array $sections, string $locale): string
    {
        return collect($sections)
            ->flatMap(fn ($section) => $section['paragraphs'] ?? [])
            ->map(fn ($paragraph) => data_get($paragraph, $locale, ''))
            ->filter()
            ->implode("\n\n");
    }

    private function bulletsFromSections(array $sections, string $locale): string
    {
        return collect($sections)
            ->flatMap(fn ($section) => $section['bullets'] ?? [])
            ->map(function ($bullet) use ($locale) {
                $label = data_get($bullet, "label.{$locale}", '');
                $text = data_get($bullet, "text.{$locale}", '');

                return trim($label !== '' ? "{$label}: {$text}" : $text);
            })
            ->filter()
            ->implode("\n");
    }

    private function splitTextareaLines(string $value): array
    {
        return collect(preg_split('/\R/u', $value) ?: [])
            ->map(fn ($line) => trim(preg_replace('/^\s*[-*•]\s*/u', '', $line) ?? ''))
            ->filter()
            ->values()
            ->all();
    }

    private function localizedParagraphs(string $bodyEs, string $bodyEn): array
    {
        $esParagraphs = collect(preg_split('/\R{2,}/u', $bodyEs) ?: [])->map(fn ($line) => trim($line))->filter()->values();
        $enParagraphs = collect(preg_split('/\R{2,}/u', $bodyEn) ?: [])->map(fn ($line) => trim($line))->filter()->values();
        $max = max($esParagraphs->count(), $enParagraphs->count());

        return collect(range(0, max(0, $max - 1)))
            ->map(fn ($index) => [
                'es' => $esParagraphs[$index] ?? ($enParagraphs[$index] ?? ''),
                'en' => $enParagraphs[$index] ?? ($esParagraphs[$index] ?? ''),
            ])
            ->filter(fn ($paragraph) => $paragraph['es'] !== '' || $paragraph['en'] !== '')
            ->values()
            ->all();
    }

    private function contentSectionsFromInputs(string $bodyEs, string $bodyEn, array $bulletsEs, array $bulletsEn): array
    {
        $contentSections = [];

        if ($bodyEs !== '' || $bodyEn !== '') {
            $contentSections[] = [
                'paragraphs' => $this->localizedParagraphs($bodyEs, $bodyEn),
            ];
        }

        if ($bulletsEs !== [] || $bulletsEn !== []) {
            $contentSections[] = [
                'bullets' => $this->localizedBullets($bulletsEs, $bulletsEn),
            ];
        }

        return $contentSections;
    }

    private function canPreserveSections(array $row, array $sections): bool
    {
        if ($sections === []) {
            return false;
        }

        return $this->sameText($row['content_es'] ?? '', $row['original_content_es'] ?? '')
            && $this->sameText($row['content_en'] ?? '', $row['original_content_en'] ?? '');
    }

    private function sameText(string $first, string $second): bool
    {
        return trim(str_replace(["\r\n", "\r"], "\n", $first)) === trim(str_replace(["\r\n", "\r"], "\n", $second));
    }

    private function encodeRawSections(array $sections): string
    {
        return $sections === [] ? '' : base64_encode(json_encode($sections, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    private function decodeRawSections(?string $value): array
    {
        if (! filled($value)) {
            return [];
        }

        $decoded = base64_decode($value, true);
        if ($decoded === false) {
            return [];
        }

        $sections = json_decode($decoded, true);

        return is_array($sections) ? $sections : [];
    }

    private function legacyContent(string $body, string $bullets): string
    {
        $lines = [trim($body)];

        foreach ($this->splitTextareaLines($bullets) as $bullet) {
            $lines[] = "- {$bullet}";
        }

        return collect($lines)->filter()->implode("\n\n");
    }

    private function smartContentFromSections(array $sections, string $locale): string
    {
        return collect($sections)
            ->map(function ($section) use ($locale) {
                $lines = [];
                $heading = data_get($section, "heading.{$locale}", '');

                if ($heading !== '') {
                    $lines[] = "## {$heading}";
                }

                foreach (($section['paragraphs'] ?? []) as $paragraph) {
                    $text = data_get($paragraph, $locale, '');
                    if ($text !== '') {
                        $lines[] = $text;
                    }
                }

                foreach (($section['bullets'] ?? []) as $bullet) {
                    $label = data_get($bullet, "label.{$locale}", '');
                    $text = data_get($bullet, "text.{$locale}", '');
                    $children = $bullet['children'] ?? [];

                    if ($label !== '' || $text !== '') {
                        $lines[] = '- '.trim($label !== '' ? "{$label}: {$text}" : $text);
                    }

                    foreach ($children as $child) {
                        $childLabel = data_get($child, "label.{$locale}", '');
                        $childText = data_get($child, "text.{$locale}", '');

                        if ($childLabel !== '' || $childText !== '') {
                            $lines[] = '  - '.trim($childLabel !== '' ? "{$childLabel}: {$childText}" : $childText);
                        }
                    }
                }

                return collect($lines)->filter()->implode("\n\n");
            })
            ->filter()
            ->implode("\n\n");
    }

    private function smartContentSections(string $contentEs, string $contentEn): array
    {
        $esSections = $this->parseSmartContent($contentEs);
        $enSections = $this->parseSmartContent($contentEn !== '' ? $contentEn : $contentEs);
        $max = max(count($esSections), count($enSections));

        if ($max === 0) {
            return [];
        }

        return collect(range(0, $max - 1))
            ->map(function (int $index) use ($esSections, $enSections) {
                $es = $esSections[$index] ?? ['heading' => null, 'paragraphs' => [], 'bullets' => []];
                $en = $enSections[$index] ?? $es;
                $section = [];

                if (($es['heading'] ?? null) || ($en['heading'] ?? null)) {
                    $section['heading'] = [
                        'es' => $es['heading'] ?? ($en['heading'] ?? ''),
                        'en' => $en['heading'] ?? ($es['heading'] ?? ''),
                    ];
                }

                $paragraphs = $this->mergeLocalizedLines($es['paragraphs'] ?? [], $en['paragraphs'] ?? []);
                if ($paragraphs !== []) {
                    $section['paragraphs'] = $paragraphs;
                }

                $bullets = $this->mergeLocalizedBullets($es['bullets'] ?? [], $en['bullets'] ?? []);
                if ($bullets !== []) {
                    $section['bullets'] = $bullets;
                }

                return $section;
            })
            ->filter(fn ($section) => array_key_exists('heading', $section) || array_key_exists('paragraphs', $section) || array_key_exists('bullets', $section))
            ->values()
            ->all();
    }

    private function parseSmartContent(string $content): array
    {
        $sections = [];
        $current = ['heading' => null, 'paragraphs' => [], 'bullets' => []];
        $paragraphBuffer = [];

        $flushParagraph = function () use (&$current, &$paragraphBuffer): void {
            if ($paragraphBuffer === []) {
                return;
            }

            $current['paragraphs'][] = trim(implode(' ', $paragraphBuffer));
            $paragraphBuffer = [];
        };

        $flushSection = function () use (&$sections, &$current, &$paragraphBuffer, $flushParagraph): void {
            $flushParagraph();

            if ($current['heading'] || $current['paragraphs'] !== [] || $current['bullets'] !== []) {
                $sections[] = $current;
            }

            $current = ['heading' => null, 'paragraphs' => [], 'bullets' => []];
            $paragraphBuffer = [];
        };

        foreach (preg_split('/\R/u', str_replace(["\r\n", "\r"], "\n", $content)) ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                $flushParagraph();
                continue;
            }

            if (preg_match('/^#{2,3}\s+(.+)$/u', $line, $matches)) {
                $flushSection();
                $current['heading'] = trim($matches[1]);
                continue;
            }

            if (preg_match('/^\s*[-*•]\s+(.+)$/u', $line, $matches)) {
                $flushParagraph();
                $current['bullets'][] = trim($matches[1]);
                continue;
            }

            $paragraphBuffer[] = $line;
        }

        $flushSection();

        return $sections;
    }

    private function mergeLocalizedLines(array $esLines, array $enLines): array
    {
        $max = max(count($esLines), count($enLines));

        if ($max === 0) {
            return [];
        }

        return collect(range(0, $max - 1))
            ->map(fn ($index) => [
                'es' => $esLines[$index] ?? ($enLines[$index] ?? ''),
                'en' => $enLines[$index] ?? ($esLines[$index] ?? ''),
            ])
            ->filter(fn ($line) => $line['es'] !== '' || $line['en'] !== '')
            ->values()
            ->all();
    }

    private function mergeLocalizedBullets(array $esBullets, array $enBullets): array
    {
        return collect($this->mergeLocalizedLines($esBullets, $enBullets))
            ->map(fn ($line) => ['text' => $line])
            ->values()
            ->all();
    }

    private function plainParagraphBody(array $sections, string $locale): string
    {
        return collect($sections)
            ->flatMap(fn ($section) => $section['paragraphs'] ?? [])
            ->map(fn ($paragraph) => data_get($paragraph, $locale, ''))
            ->filter()
            ->implode("\n\n");
    }

    private function localizedBullets(array $bulletsEs, array $bulletsEn): array
    {
        $max = max(count($bulletsEs), count($bulletsEn));

        return collect(range(0, max(0, $max - 1)))
            ->map(fn ($index) => [
                'text' => [
                    'es' => $bulletsEs[$index] ?? ($bulletsEn[$index] ?? ''),
                    'en' => $bulletsEn[$index] ?? ($bulletsEs[$index] ?? ''),
                ],
            ])
            ->filter(fn ($bullet) => $bullet['text']['es'] !== '' || $bullet['text']['en'] !== '')
            ->values()
            ->all();
    }

    private function validatedLinks(array $rows): array
    {
        return collect($rows)
            ->filter(fn ($row) => filled($row['label_es'] ?? null) || filled($row['label_en'] ?? null) || filled($row['href'] ?? null))
            ->map(function (array $row) {
                $labelEs = trim($row['label_es'] ?? '');
                $labelEn = trim($row['label_en'] ?? '') ?: $labelEs;

                return [
                    'href' => trim($row['href'] ?? ''),
                    'label' => [
                        'es' => $labelEs,
                        'en' => $labelEn,
                    ],
                ];
            })
            ->filter(fn ($row) => $row['href'] !== '' && $row['label']['es'] !== '')
            ->values()
            ->all();
    }

    private function syncItems(Section $targetSection, Section $otherSection, array $items, string $type, $languages): void
    {
        abort_unless(in_array($type, self::TYPE_OPTIONS, true), 422);

        $keptIds = [];

        foreach ($items as $index => $item) {
            $block = $item['id']
                ? ContentBlock::query()->whereIn('section_id', [$targetSection->id, $otherSection->id])->where('id', $item['id'])->first()
                : null;

            $slug = $block?->data['slug'] ?? Str::slug($item['name_es']);
            $href = $item['url'] !== '' ? $item['url'] : "/becas-movilidad/becas/{$slug}";

            if (! $block) {
                $block = new ContentBlock();
            }

            $block->fill([
                'section_id' => $targetSection->id,
                'link_url' => "/becas-movilidad/becas/{$slug}",
                'block_type' => $type,
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => [
                    'slug' => $slug,
                    'region_es' => $item['region_es'],
                    'region_en' => $item['region_en'],
                    'href' => $href,
                    'accent' => $type === 'country' ? '#003770' : '#E30613',
                    'parent_slug' => null,
                    'opportunities' => $block->data['opportunities'] ?? [],
                ],
                'media_asset_id' => null,
            ]);
            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $item['name_es'] : $item['name_en'],
                        'subtitle' => $locale === 'es' ? $item['region_es'] : $item['region_en'],
                        'summary' => $locale === 'es' ? $item['summary_es'] : $item['summary_en'],
                        'body' => null,
                        'cta_label' => null,
                    ]
                );
            }
        }

        ContentBlock::query()
            ->whereIn('section_id', [$targetSection->id, $otherSection->id])
            ->where('block_type', $type)
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

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function authorizeScholarshipAccess(Page $page): void
    {
        abort_unless($page->slug === 'becas', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }

    private function authorizeScholarshipBlockAccess(ContentBlock $block): Page
    {
        $block->loadMissing(['section.page']);
        $page = $block->section?->page;

        abort_unless($page instanceof Page && $page->slug === 'becas', 404);
        abort_unless(in_array($block->block_type, self::TYPE_OPTIONS, true), 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');

        return $page;
    }
}
