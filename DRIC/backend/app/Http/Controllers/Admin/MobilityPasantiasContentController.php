<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\MediaTranslation;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\MobilityProgramStaticDetails;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MobilityPasantiasContentController extends Controller
{
    private const MAX_PDF_KB = 20480;

    private const TRACKS = [
        'students' => [
            'track_id' => 'estudiantes',
            'section_key' => 'mobility.estudiantes',
            'sort_order' => 1,
            'title' => 'Movilidad estudiantil',
            'button' => 'Agregar programa estudiantil',
        ],
        'staff' => [
            'track_id' => 'docentes-administrativos',
            'section_key' => 'mobility.docentes-administrativos',
            'sort_order' => 2,
            'title' => 'Movilidad docente / administrativa',
            'button' => 'Agregar programa docente o administrativo',
        ],
    ];

    public function edit(Page $page): View
    {
        $this->authorizeAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.mobility-pasantias-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'tracks' => self::TRACKS,
            'programs' => [
                'students' => $this->programs($page, 'estudiantes'),
                'staff' => $this->programs($page, 'docentes-administrativos'),
            ],
            'hubPage' => Page::query()->where('slug', 'becas-movilidad')->first(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $studentPrograms = $this->validatedPrograms($request, 'students', 'estudiantes');
        $staffPrograms = $this->validatedPrograms($request, 'staff', 'docentes-administrativos');

        DB::transaction(function () use ($request, $validated, $studentPrograms, $staffPrograms, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $studentSection = $this->upsertSection($page, self::TRACKS['students']);
            $staffSection = $this->upsertSection($page, self::TRACKS['staff']);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['menu_title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $studentSection->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['students_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['students_intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $staffSection->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['staff_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['staff_intro'],
                        'body' => null,
                    ]
                );
            }

            $this->syncPrograms($studentSection, $studentPrograms, $languages);
            $this->syncPrograms($staffSection, $staffPrograms, $languages);
        });

        return redirect()
            ->route('admin.pages.mobility-pasantias.edit', $page)
            ->with('success', 'El contenido de Movilidad y Pasantías fue actualizado correctamente.');
    }

    public function editDetail(ContentBlock $block): View
    {
        $page = $this->authorizeBlockAccess($block);
        $block->loadMissing(['translations.language']);

        return view('admin.pages.mobility-pasantias-detail', [
            'page' => $page,
            'block' => $block,
            'name' => [
                'es' => $block->translations->firstWhere('language.code', 'es')?->title ?? 'Programa de movilidad',
                'en' => $block->translations->firstWhere('language.code', 'en')?->title ?? 'Mobility program',
            ],
            'detail' => $this->detailContent($block),
        ]);
    }

    public function updateDetail(Request $request, ContentBlock $block): RedirectResponse
    {
        $this->authorizeBlockAccess($block);

        $validated = Validator::make($request->all(), $this->detailRules(), $this->detailMessages())->validate();
        $highlights = $this->validatedHighlights($request);
        $sections = $this->validatedDetailSections($request);
        $calls = $this->validatedCalls($request);

        $data = $block->data ?? [];
        $reference = $this->referenceData($request, $validated, $data['reference'] ?? null);
        $hasCustomDetail = $highlights !== [] || $sections !== [] || $calls !== [] || $reference !== null;

        $data['detail_edited'] = $hasCustomDetail;
        $data['highlights'] = $highlights;
        $data['sections'] = $sections;
        $data['reference'] = $reference;
        $data['calls'] = $calls;

        $block->forceFill(['data' => $data])->save();

        return redirect()
            ->route('admin.mobility-programs.detail.edit', $block)
            ->with('success', 'El detalle del programa fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.menu_title"] = ['required', 'string', 'max:140'];
            $rules["{$locale}.eyebrow"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:1200'];
            $rules["{$locale}.students_title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.students_intro"] = ['required', 'string', 'max:1000'];
            $rules["{$locale}.staff_title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.staff_intro"] = ['required', 'string', 'max:1000'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera el tamaño permitido.',
        ];
    }

    private function detailRules(): array
    {
        return [
            'reference.label_es' => ['nullable', 'string', 'max:180'],
            'reference.label_en' => ['nullable', 'string', 'max:180'],
            'reference.href' => ['nullable', 'string', 'max:900'],
            'reference.existing_href' => ['nullable', 'string', 'max:900'],
            'reference.existing_media_asset_id' => ['nullable', 'integer'],
            'reference.pdf' => ['nullable', 'file', 'mimes:pdf', 'max:'.self::MAX_PDF_KB],
        ];
    }

    private function detailMessages(): array
    {
        return [
            'reference.pdf.mimes' => 'Ese formato no está permitido. Sube un PDF.',
            'reference.pdf.max' => 'El PDF sobrepasa los 20MB.',
            'max' => 'Este campo supera el tamaño permitido.',
            'string' => 'Este campo debe contener texto.',
        ];
    }

    private function validatedPrograms(Request $request, string $key, string $trackId): array
    {
        $rows = collect($request->input($key, []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['url'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            [$key => $rows],
            [
                "{$key}" => ['array'],
                "{$key}.*.id" => ['nullable', 'integer'],
                "{$key}.*.title_es" => ['required', 'string', 'max:220'],
                "{$key}.*.title_en" => ['nullable', 'string', 'max:220'],
                "{$key}.*.tag_es" => ['required', 'string', 'max:120'],
                "{$key}.*.tag_en" => ['nullable', 'string', 'max:120'],
                "{$key}.*.summary_es" => ['required', 'string', 'max:1200'],
                "{$key}.*.summary_en" => ['nullable', 'string', 'max:1200'],
                "{$key}.*.conditions_es" => ['nullable', 'string', 'max:6000'],
                "{$key}.*.conditions_en" => ['nullable', 'string', 'max:6000'],
                "{$key}.*.url" => ['nullable', 'string', 'max:900'],
            ],
            [
                "{$key}.*.title_es.required" => 'Escribe el título del programa en español.',
                "{$key}.*.tag_es.required" => 'Escribe la etiqueta del programa en español.',
                "{$key}.*.summary_es.required" => 'Escribe la descripción del programa en español.',
                "{$key}.*.max" => 'Este campo supera el tamaño permitido.',
            ]
        );

        return collect($validator->validate()[$key] ?? [])
            ->map(function (array $row) use ($trackId): array {
                $titleEs = trim($row['title_es']);
                $slug = Str::slug($titleEs.' '.$trackId) ?: (string) Str::uuid();

                return [
                    'id' => isset($row['id']) ? (int) $row['id'] : null,
                    'track_id' => $trackId,
                    'slug' => $slug,
                    'title_es' => $titleEs,
                    'title_en' => trim($row['title_en'] ?? '') ?: $titleEs,
                    'tag_es' => trim($row['tag_es']),
                    'tag_en' => trim($row['tag_en'] ?? '') ?: trim($row['tag_es']),
                    'summary_es' => trim($row['summary_es']),
                    'summary_en' => trim($row['summary_en'] ?? '') ?: trim($row['summary_es']),
                    'conditions_es' => $this->linesToList($row['conditions_es'] ?? ''),
                    'conditions_en' => $this->linesToList($row['conditions_en'] ?? '') ?: $this->linesToList($row['conditions_es'] ?? ''),
                    'url' => trim($row['url'] ?? ''),
                ];
            })
            ->all();
    }

    private function validatedHighlights(Request $request): array
    {
        $rows = collect($request->input('highlights', []))
            ->filter(fn ($row) => filled($row['label_es'] ?? null) || filled($row['value_es'] ?? null) || filled($row['label_en'] ?? null) || filled($row['value_en'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['highlights' => $rows],
            [
                'highlights' => ['array'],
                'highlights.*.label_es' => ['required', 'string', 'max:120'],
                'highlights.*.label_en' => ['nullable', 'string', 'max:120'],
                'highlights.*.value_es' => ['required', 'string', 'max:260'],
                'highlights.*.value_en' => ['nullable', 'string', 'max:260'],
            ],
            [
                'highlights.*.label_es.required' => 'Escribe la etiqueta del dato clave.',
                'highlights.*.value_es.required' => 'Escribe el valor del dato clave.',
                'highlights.*.max' => 'Este campo supera el tamaño permitido.',
            ]
        );

        return collect($validator->validate()['highlights'] ?? [])
            ->map(fn (array $row) => [
                'label' => $this->localized(trim($row['label_es']), trim($row['label_en'] ?? '')),
                'value' => $this->localized(trim($row['value_es']), trim($row['value_en'] ?? '')),
            ])
            ->all();
    }

    private function validatedDetailSections(Request $request): array
    {
        $rows = collect($request->input('sections', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['content_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['content_en'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['sections' => $rows],
            [
                'sections' => ['array'],
                'sections.*.title_es' => ['required', 'string', 'max:220'],
                'sections.*.title_en' => ['nullable', 'string', 'max:220'],
                'sections.*.content_es' => ['nullable', 'string', 'max:12000'],
                'sections.*.content_en' => ['nullable', 'string', 'max:12000'],
            ],
            [
                'sections.*.title_es.required' => 'Escribe el título de la sección.',
                'sections.*.max' => 'Este campo supera el tamaño permitido.',
            ]
        );

        return collect($validator->validate()['sections'] ?? [])
            ->map(function (array $row): array {
                $parsedEs = $this->parseBodyAndBullets($row['content_es'] ?? '');
                $parsedEn = $this->parseBodyAndBullets($row['content_en'] ?? '') ?: $parsedEs;

                return [
                    'title' => $this->localized(trim($row['title_es']), trim($row['title_en'] ?? '')),
                    'body' => [
                        'es' => $parsedEs['body'],
                        'en' => $parsedEn['body'] ?: $parsedEs['body'],
                    ],
                    'items' => [
                        'es' => $parsedEs['items'],
                        'en' => $parsedEn['items'] ?: $parsedEs['items'],
                    ],
                ];
            })
            ->all();
    }

    private function validatedCalls(Request $request): array
    {
        $rows = collect($request->input('calls', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['description_es'] ?? null) || filled($row['id'] ?? null))
            ->all();
        $files = $request->file('calls', []);

        $validator = Validator::make(
            ['calls' => $rows],
            [
                'calls' => ['array'],
                'calls.*.id' => ['nullable', 'string', 'max:80'],
                'calls.*.title_es' => ['required', 'string', 'max:260'],
                'calls.*.title_en' => ['nullable', 'string', 'max:260'],
                'calls.*.description_es' => ['required', 'string', 'max:1800'],
                'calls.*.description_en' => ['nullable', 'string', 'max:1800'],
                'calls.*.benefits_es' => ['nullable', 'string', 'max:6000'],
                'calls.*.benefits_en' => ['nullable', 'string', 'max:6000'],
                'calls.*.documents_es' => ['nullable', 'string', 'max:6000'],
                'calls.*.documents_en' => ['nullable', 'string', 'max:6000'],
                'calls.*.deadline_es' => ['nullable', 'string', 'max:260'],
                'calls.*.deadline_en' => ['nullable', 'string', 'max:260'],
                'calls.*.note_es' => ['nullable', 'string', 'max:1200'],
                'calls.*.note_en' => ['nullable', 'string', 'max:1200'],
                'calls.*.links' => ['nullable', 'array'],
                'calls.*.links.*.label_es' => ['nullable', 'string', 'max:180'],
                'calls.*.links.*.label_en' => ['nullable', 'string', 'max:180'],
                'calls.*.links.*.href' => ['nullable', 'string', 'max:900'],
                'calls.*.links.*.existing_href' => ['nullable', 'string', 'max:900'],
                'calls.*.links.*.existing_media_asset_id' => ['nullable', 'integer'],
            ],
            [
                'calls.*.title_es.required' => 'Escribe el título de la convocatoria.',
                'calls.*.description_es.required' => 'Escribe la descripción de la convocatoria.',
                'calls.*.max' => 'Este campo supera el tamaño permitido.',
            ]
        );

        $validator->after(function ($validator) use ($rows, $files): void {
            foreach ($rows as $callIndex => $call) {
                foreach (($call['links'] ?? []) as $linkIndex => $link) {
                    $hasLabel = filled($link['label_es'] ?? null) || filled($link['label_en'] ?? null);
                    $hasHref = filled($link['href'] ?? null) || filled($link['existing_href'] ?? null);
                    $file = data_get($files, "{$callIndex}.links.{$linkIndex}.pdf");
                    $hasFile = $file && $file->isValid();

                    if ($hasLabel && ! $hasHref && ! $hasFile) {
                        $validator->errors()->add("calls.{$callIndex}.links.{$linkIndex}.href", 'Agrega una URL o sube un PDF para este enlace.');
                    }

                    if (! $hasFile) {
                        continue;
                    }

                    if ($file->getClientOriginalExtension() !== 'pdf' && $file->getMimeType() !== 'application/pdf') {
                        $validator->errors()->add("calls.{$callIndex}.links.{$linkIndex}.pdf", 'Ese formato no está permitido. Sube un PDF.');
                    }

                    if ($file->getSize() > self::MAX_PDF_KB * 1024) {
                        $validator->errors()->add("calls.{$callIndex}.links.{$linkIndex}.pdf", 'El PDF sobrepasa los 20MB.');
                    }
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['calls'] ?? [])
            ->map(function (array $row, int $callIndex) use ($files): array {
                return [
                    'id' => $row['id'] ?? (string) Str::uuid(),
                    'title' => $this->localized(trim($row['title_es']), trim($row['title_en'] ?? '')),
                    'description' => $this->localized(trim($row['description_es']), trim($row['description_en'] ?? '')),
                    'benefits' => $this->localizedList($row['benefits_es'] ?? '', $row['benefits_en'] ?? ''),
                    'documents' => $this->localizedList($row['documents_es'] ?? '', $row['documents_en'] ?? ''),
                    'deadline' => $this->localizedNullable(trim($row['deadline_es'] ?? ''), trim($row['deadline_en'] ?? '')),
                    'note' => $this->localizedNullable(trim($row['note_es'] ?? ''), trim($row['note_en'] ?? '')),
                    'links' => $this->validatedCallLinks($row['links'] ?? [], data_get($files, "{$callIndex}.links", [])),
                ];
            })
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'menu_title' => $this->pageValue($page, 'es', 'menu_title', 'Movilidad y pasantías'),
                'eyebrow' => $this->pageValue($page, 'es', 'subtitle', 'Movilidad y pasantías internacionales'),
                'title' => $this->pageValue($page, 'es', 'title', 'Programas de movilidad'),
                'intro' => $this->pageValue($page, 'es', 'summary', 'La DRIC canaliza programas de movilidad estudiantil, docente y administrativa, además de pasantías internacionales que fortalecen la formación académica, la cooperación institucional y la integración regional.'),
                'students_title' => $this->sectionValue($page, 'mobility.estudiantes', 'es', 'title', 'Movilidad estudiantil'),
                'students_intro' => $this->sectionValue($page, 'mobility.estudiantes', 'es', 'summary', 'Opciones para que estudiantes de la UMSS realicen intercambios, estancias académicas o pasantías en instituciones y empresas internacionales.'),
                'staff_title' => $this->sectionValue($page, 'mobility.docentes-administrativos', 'es', 'title', 'Movilidad docente / administrativa'),
                'staff_intro' => $this->sectionValue($page, 'mobility.docentes-administrativos', 'es', 'summary', 'Programas dirigidos a docentes, gestores y personal administrativo para realizar movilidad académica, formación, docencia, investigación e intercambio institucional.'),
            ],
            'en' => [
                'menu_title' => $this->pageValue($page, 'en', 'menu_title', 'Mobility and internships'),
                'eyebrow' => $this->pageValue($page, 'en', 'subtitle', 'International mobility and internships'),
                'title' => $this->pageValue($page, 'en', 'title', 'Mobility programs'),
                'intro' => $this->pageValue($page, 'en', 'summary', 'DRIC channels student, faculty and administrative mobility programs, as well as international internships that strengthen academic training, institutional cooperation and regional integration.'),
                'students_title' => $this->sectionValue($page, 'mobility.estudiantes', 'en', 'title', 'Student mobility'),
                'students_intro' => $this->sectionValue($page, 'mobility.estudiantes', 'en', 'summary', 'Options for UMSS students to complete exchanges, academic stays or internships at international institutions and companies.'),
                'staff_title' => $this->sectionValue($page, 'mobility.docentes-administrativos', 'en', 'title', 'Faculty / administrative mobility'),
                'staff_intro' => $this->sectionValue($page, 'mobility.docentes-administrativos', 'en', 'summary', 'Programs for faculty, managers and administrative staff to complete academic mobility, training, teaching, research and institutional exchange.'),
            ],
        ];
    }

    private function programs(Page $page, string $trackId): array
    {
        $section = $page->sections->first(function (Section $section) use ($trackId): bool {
            return ($section->settings['track_id'] ?? null) === $trackId
                || $section->section_key === "mobility.{$trackId}";
        });

        return ($section?->contentBlocks ?? collect())
            ->where('block_type', 'mobility_program')
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'tag_es' => $block->translations->firstWhere('language.code', 'es')?->subtitle ?? ($block->data['tag'] ?? ''),
                'tag_en' => $block->translations->firstWhere('language.code', 'en')?->subtitle ?? ($block->data['tag_en'] ?? ''),
                'summary_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'summary_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
                'conditions_es' => implode("\n", $block->data['conditions_es'] ?? $block->data['conditions'] ?? []),
                'conditions_en' => implode("\n", $block->data['conditions_en'] ?? $block->data['conditions'] ?? []),
                'url' => $block->link_url ?? ($block->data['href'] ?? ''),
            ])
            ->all();
    }

    private function detailContent(ContentBlock $block): array
    {
        $data = $block->data ?? [];
        $fallback = $this->fallbackDetailForBlock($block);
        $source = $this->hasStoredDetail($data) ? $data : $fallback;
        $reference = $this->referenceForm($source['reference'] ?? null);

        return [
            'highlights' => collect($source['highlights'] ?? [])->map(fn ($item) => [
                'label_es' => data_get($item, 'label.es', ''),
                'label_en' => data_get($item, 'label.en', data_get($item, 'label.es', '')),
                'value_es' => data_get($item, 'value.es', ''),
                'value_en' => data_get($item, 'value.en', data_get($item, 'value.es', '')),
            ])->all(),
            'sections' => collect($source['sections'] ?? [])->map(fn ($item) => [
                'title_es' => data_get($item, 'title.es', ''),
                'title_en' => data_get($item, 'title.en', data_get($item, 'title.es', '')),
                'content_es' => $this->sectionContentForForm($item, 'es'),
                'content_en' => $this->sectionContentForForm($item, 'en'),
            ])->all(),
            'reference' => $reference,
            'calls' => collect($source['calls'] ?? [])->map(fn ($item) => [
                'id' => $item['id'] ?? (string) Str::uuid(),
                'title_es' => data_get($item, 'title.es', ''),
                'title_en' => data_get($item, 'title.en', data_get($item, 'title.es', '')),
                'description_es' => data_get($item, 'description.es', ''),
                'description_en' => data_get($item, 'description.en', data_get($item, 'description.es', '')),
                'benefits_es' => implode("\n", data_get($item, 'benefits.es', [])),
                'benefits_en' => implode("\n", data_get($item, 'benefits.en', data_get($item, 'benefits.es', []))),
                'documents_es' => implode("\n", data_get($item, 'documents.es', [])),
                'documents_en' => implode("\n", data_get($item, 'documents.en', data_get($item, 'documents.es', []))),
                'deadline_es' => data_get($item, 'deadline.es', ''),
                'deadline_en' => data_get($item, 'deadline.en', data_get($item, 'deadline.es', '')),
                'note_es' => data_get($item, 'note.es', ''),
                'note_en' => data_get($item, 'note.en', data_get($item, 'note.es', '')),
                'links' => $this->linksForForm($item['links'] ?? []),
            ])->all(),
        ];
    }

    private function hasStoredDetail(array $data): bool
    {
        return ($data['detail_edited'] ?? false) === true
            || ! empty($data['highlights'])
            || ! empty($data['sections'])
            || ! empty($data['reference'])
            || ! empty($data['calls']);
    }

    private function fallbackDetailForBlock(ContentBlock $block): array
    {
        $data = $block->data ?? [];
        $slug = $data['slug'] ?? ($block->link_url ? collect(explode('/', $block->link_url))->filter()->last() : null);

        return MobilityProgramStaticDetails::forSlug(is_string($slug) ? $slug : null);
    }

    private function referenceForm(?array $reference): array
    {
        return [
            'label_es' => data_get($reference, 'label.es', ''),
            'label_en' => data_get($reference, 'label.en', data_get($reference, 'label.es', '')),
            'href' => data_get($reference, 'href', ''),
            'existing_href' => data_get($reference, 'href', ''),
            'existing_media_asset_id' => data_get($reference, 'media_asset_id', ''),
        ];
    }

    private function sectionContentForForm(array $item, string $locale): string
    {
        $body = data_get($item, "body.{$locale}", '');
        $items = data_get($item, "items.{$locale}", []);
        $lines = [];

        if ($body !== '') {
            $lines[] = $body;
        }

        foreach ($items as $bullet) {
            $lines[] = '- '.$bullet;
        }

        return implode("\n", $lines);
    }

    private function linksForForm(array $links): array
    {
        return collect($links)->map(fn ($link) => [
            'label_es' => data_get($link, 'label.es', ''),
            'label_en' => data_get($link, 'label.en', data_get($link, 'label.es', '')),
            'href' => data_get($link, 'href', ''),
            'existing_href' => data_get($link, 'href', ''),
            'existing_media_asset_id' => data_get($link, 'media_asset_id', ''),
        ])->all();
    }

    private function referenceData(Request $request, array $validated, ?array $existing): ?array
    {
        $reference = $validated['reference'] ?? [];
        $labelEs = trim($reference['label_es'] ?? '');
        $labelEn = trim($reference['label_en'] ?? '') ?: $labelEs;
        $href = trim($reference['href'] ?? '') ?: trim($reference['existing_href'] ?? '');
        $mediaAssetId = $reference['existing_media_asset_id'] ?? ($existing['media_asset_id'] ?? null);

        if ($request->hasFile('reference.pdf')) {
            $media = $this->storePdfFile($request->file('reference.pdf'), $request->user()->id);
            $href = '/storage/'.ltrim($media->file_path, '/');
            $mediaAssetId = $media->id;
        }

        if ($labelEs === '' && $href === '') {
            return null;
        }

        return [
            'label' => ['es' => $labelEs ?: 'Ver enlace', 'en' => $labelEn ?: ($labelEs ?: 'Open link')],
            'href' => $href,
            'media_asset_id' => $mediaAssetId ? (int) $mediaAssetId : null,
        ];
    }

    private function validatedCallLinks(array $rows, array $files): array
    {
        return collect($rows)
            ->filter(fn ($row) => filled($row['label_es'] ?? null) || filled($row['label_en'] ?? null) || filled($row['href'] ?? null) || filled($row['existing_href'] ?? null))
            ->map(function (array $row, int $index) use ($files): ?array {
                $labelEs = trim($row['label_es'] ?? '');
                $labelEn = trim($row['label_en'] ?? '') ?: $labelEs;
                $href = trim($row['href'] ?? '') ?: trim($row['existing_href'] ?? '');
                $mediaAssetId = $row['existing_media_asset_id'] ?? null;
                $file = $files[$index]['pdf'] ?? null;

                if ($file && $file->isValid()) {
                    $media = $this->storePdfFile($file, auth()->id());
                    $href = '/storage/'.ltrim($media->file_path, '/');
                    $mediaAssetId = $media->id;
                }

                if ($labelEs === '' || $href === '') {
                    return null;
                }

                return [
                    'label' => ['es' => $labelEs, 'en' => $labelEn],
                    'href' => $href,
                    'media_asset_id' => $mediaAssetId ? (int) $mediaAssetId : null,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private function parseBodyAndBullets(string $value): array
    {
        $paragraphs = [];
        $items = [];

        foreach (preg_split('/\R/u', str_replace(["\r\n", "\r"], "\n", $value)) ?: [] as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (preg_match('/^\s*[-*•]\s+(.+)$/u', $line, $matches)) {
                $items[] = trim($matches[1]);
                continue;
            }

            $paragraphs[] = preg_replace('/^#{2,3}\s+/u', '', $line) ?? $line;
        }

        return [
            'body' => trim(implode("\n\n", $paragraphs)),
            'items' => $items,
        ];
    }

    private function localized(string $es, string $en): array
    {
        return ['es' => $es, 'en' => $en !== '' ? $en : $es];
    }

    private function localizedNullable(string $es, string $en): ?array
    {
        if ($es === '' && $en === '') {
            return null;
        }

        return $this->localized($es, $en);
    }

    private function localizedList(string $es, string $en): array
    {
        $esList = $this->linesToList($es);
        $enList = $this->linesToList($en);

        return [
            'es' => $esList,
            'en' => $enList !== [] ? $enList : $esList,
        ];
    }

    private function storePdfFile($file, ?int $userId): MediaAsset
    {
        $path = $file->store('movilidad-pasantias', 'public');
        $media = MediaAsset::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'disk' => 'public',
            'uploaded_by' => $userId,
        ]);

        foreach (Language::query()->whereIn('code', ['es', 'en'])->get() as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                ['alt_text' => 'Documento del programa de movilidad', 'caption' => null]
            );
        }

        return $media;
    }

    private function syncPrograms(Section $section, array $programs, $languages): void
    {
        $keptIds = [];

        foreach ($programs as $index => $program) {
            $block = isset($program['id'])
                ? ContentBlock::query()->where('section_id', $section->id)->whereKey($program['id'])->first()
                : null;

            $existingData = $block?->data ?? [];
            $slug = $existingData['slug'] ?? $program['slug'];
            $url = $program['url'] ?: ($block?->link_url ?: "/becas-movilidad/movilidad-pasantias/{$slug}");

            $values = [
                'section_id' => $section->id,
                'block_type' => 'mobility_program',
                'sort_order' => $index + 1,
                'is_active' => true,
                'link_url' => $url,
                'data' => array_merge($existingData, [
                    'slug' => $slug,
                    'tag' => $program['tag_es'],
                    'tag_en' => $program['tag_en'],
                    'conditions_es' => $program['conditions_es'],
                    'conditions_en' => $program['conditions_en'],
                    'track_id' => $program['track_id'],
                    'href' => $url,
                    'editable' => true,
                ]),
                'media_asset_id' => null,
            ];

            if ($block) {
                $block->forceFill($values)->save();
            } else {
                $block = ContentBlock::create($values);
            }

            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $program["title_{$locale}"],
                        'subtitle' => $program["tag_{$locale}"],
                        'summary' => $program["summary_{$locale}"],
                        'body' => null,
                    ]
                );
            }
        }

        $section->contentBlocks()
            ->where('block_type', 'mobility_program')
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }

    private function upsertSection(Page $page, array $track): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $track['section_key']],
            [
                'section_type' => 'mobility_track',
                'sort_order' => $track['sort_order'],
                'is_active' => true,
                'settings' => [
                    'editable' => true,
                    'track_id' => $track['track_id'],
                ],
            ]
        );
    }

    private function linesToList(string $value): array
    {
        return collect(preg_split('/\R/u', $value) ?: [])
            ->map(fn (string $line) => trim(preg_replace('/^[\s\-\*\x{2022}]+/u', '', $line) ?? ''))
            ->filter()
            ->values()
            ->all();
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function authorizeAccess(Page $page): void
    {
        abort_unless($page->slug === 'movilidad-pasantias', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403);
    }

    private function authorizeBlockAccess(ContentBlock $block): Page
    {
        $block->loadMissing(['section.page']);
        $page = $block->section?->page;

        abort_unless($page instanceof Page && $page->slug === 'movilidad-pasantias', 404);
        abort_unless($block->block_type === 'mobility_program', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403);

        return $page;
    }
}
