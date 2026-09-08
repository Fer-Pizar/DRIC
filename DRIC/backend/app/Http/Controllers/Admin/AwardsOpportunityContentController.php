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
use App\Support\AwardsOpportunityStaticContent;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AwardsOpportunityContentController extends Controller
{
    public function edit(Page $page): View
    {
        $this->authorizeAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.awards-opportunities-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'opportunities' => $this->opportunities($page),
            'hubPage' => Page::query()->where('slug', 'becas-movilidad')->first(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $opportunities = $this->validatedOpportunities($request);

        DB::transaction(function () use ($request, $validated, $opportunities, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'awards_opportunities.hero', 'awards_opportunities_hero', 1);
            $list = $this->upsertSection($page, 'awards_opportunities.items', 'awards_opportunities_list', 2);

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
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );
            }

            $this->syncOpportunities($list, $opportunities, $languages);
        });

        return redirect()
            ->route('admin.pages.awards-opportunities.edit', $page)
            ->with('success', 'El contenido de Premios, eventos, cursos y concursos fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.menu_title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.eyebrow"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:220'];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:1200'];
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

    private function validatedOpportunities(Request $request): array
    {
        $rows = collect($request->input('opportunities', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['summary_es'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['opportunities' => $rows],
            [
                'opportunities' => ['array'],
                'opportunities.*.id' => ['nullable', 'integer'],
                'opportunities.*.title_es' => ['required', 'string', 'max:260'],
                'opportunities.*.title_en' => ['nullable', 'string', 'max:260'],
                'opportunities.*.category_es' => ['required', 'string', 'max:140'],
                'opportunities.*.category_en' => ['nullable', 'string', 'max:140'],
                'opportunities.*.audience_es' => ['required', 'string', 'max:900'],
                'opportunities.*.audience_en' => ['nullable', 'string', 'max:900'],
                'opportunities.*.summary_es' => ['required', 'string', 'max:1400'],
                'opportunities.*.summary_en' => ['nullable', 'string', 'max:1400'],
                'opportunities.*.dates_es' => ['nullable', 'string', 'max:260'],
                'opportunities.*.dates_en' => ['nullable', 'string', 'max:260'],
                'opportunities.*.deadline_es' => ['nullable', 'string', 'max:260'],
                'opportunities.*.deadline_en' => ['nullable', 'string', 'max:260'],
                'opportunities.*.location_es' => ['nullable', 'string', 'max:300'],
                'opportunities.*.location_en' => ['nullable', 'string', 'max:300'],
                'opportunities.*.format_es' => ['nullable', 'string', 'max:260'],
                'opportunities.*.format_en' => ['nullable', 'string', 'max:260'],
                'opportunities.*.details_es' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.details_en' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.benefits_es' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.benefits_en' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.requirements_es' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.requirements_en' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.documents_es' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.documents_en' => ['nullable', 'string', 'max:8000'],
                'opportunities.*.contact' => ['nullable', 'string', 'max:260'],
                'opportunities.*.links' => ['nullable', 'array'],
                'opportunities.*.links.*.label_es' => ['nullable', 'string', 'max:180'],
                'opportunities.*.links.*.label_en' => ['nullable', 'string', 'max:180'],
                'opportunities.*.links.*.href' => ['nullable', 'string', 'max:900'],
            ],
            [
                'opportunities.*.title_es.required' => 'Escribe el título de la oportunidad en español.',
                'opportunities.*.category_es.required' => 'Escribe la categoría en español.',
                'opportunities.*.audience_es.required' => 'Escribe a quién está dirigida la oportunidad.',
                'opportunities.*.summary_es.required' => 'Escribe el resumen de la oportunidad.',
                'opportunities.*.max' => 'Este campo supera el tamaño permitido.',
            ]
        );

        $validator->after(function ($validator) use ($rows): void {
            foreach ($rows as $index => $row) {
                foreach (($row['links'] ?? []) as $linkIndex => $link) {
                    $hasLabel = filled($link['label_es'] ?? null) || filled($link['label_en'] ?? null);
                    $hasHref = filled($link['href'] ?? null);

                    if ($hasLabel && ! $hasHref) {
                        $validator->errors()->add("opportunities.{$index}.links.{$linkIndex}.href", 'Agrega una URL para este enlace.');
                    }
                }
            }
        });

        return collect($validator->validate()['opportunities'] ?? [])
            ->map(fn (array $row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'title' => $this->localized(trim($row['title_es']), trim($row['title_en'] ?? '')),
                'category' => $this->localized(trim($row['category_es']), trim($row['category_en'] ?? '')),
                'audience' => $this->localized(trim($row['audience_es']), trim($row['audience_en'] ?? '')),
                'summary' => $this->localized(trim($row['summary_es']), trim($row['summary_en'] ?? '')),
                'dates' => $this->localizedNullable(trim($row['dates_es'] ?? ''), trim($row['dates_en'] ?? '')),
                'deadline' => $this->localizedNullable(trim($row['deadline_es'] ?? ''), trim($row['deadline_en'] ?? '')),
                'location' => $this->localizedNullable(trim($row['location_es'] ?? ''), trim($row['location_en'] ?? '')),
                'format' => $this->localizedNullable(trim($row['format_es'] ?? ''), trim($row['format_en'] ?? '')),
                'details' => $this->localizedLines($row['details_es'] ?? '', $row['details_en'] ?? ''),
                'benefits' => $this->localizedLines($row['benefits_es'] ?? '', $row['benefits_en'] ?? ''),
                'requirements' => $this->localizedLines($row['requirements_es'] ?? '', $row['requirements_en'] ?? ''),
                'documents' => $this->localizedLines($row['documents_es'] ?? '', $row['documents_en'] ?? ''),
                'links' => $this->validatedLinks($row['links'] ?? []),
                'contact' => trim($row['contact'] ?? ''),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        $fallback = AwardsOpportunityStaticContent::all()['copy'] ?? [];

        return [
            'es' => [
                'menu_title' => $this->pageValue($page, 'es', 'menu_title', data_get($fallback, 'es.title', 'Premios, eventos, cursos y concursos')),
                'eyebrow' => $this->sectionValue($page, 'awards_opportunities.hero', 'es', 'subtitle', data_get($fallback, 'es.eyebrow', 'Convocatorias academicas')),
                'title' => $this->pageValue($page, 'es', 'title', data_get($fallback, 'es.title', 'Premios, eventos, cursos y concursos')),
                'intro' => $this->sectionValue($page, 'awards_opportunities.hero', 'es', 'summary', data_get($fallback, 'es.intro', 'Oportunidades de formación, investigación, liderazgo, intercambio académico y participación internacional difundidas por la DRIC para la comunidad universitaria.')),
            ],
            'en' => [
                'menu_title' => $this->pageValue($page, 'en', 'menu_title', data_get($fallback, 'en.title', 'Awards, events, courses and contests')),
                'eyebrow' => $this->sectionValue($page, 'awards_opportunities.hero', 'en', 'subtitle', data_get($fallback, 'en.eyebrow', 'Academic calls')),
                'title' => $this->pageValue($page, 'en', 'title', data_get($fallback, 'en.title', 'Awards, events, courses and contests')),
                'intro' => $this->sectionValue($page, 'awards_opportunities.hero', 'en', 'summary', data_get($fallback, 'en.intro', 'Training, research, leadership, academic exchange, and international participation opportunities shared by DRIC for the university community.')),
            ],
        ];
    }

    private function opportunities(Page $page): array
    {
        $blocks = $page->sections
            ->firstWhere('section_key', 'awards_opportunities.items')
            ?->contentBlocks
            ->where('block_type', 'awards_opportunity')
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values();

        if ($blocks && $blocks->isNotEmpty()) {
            return $blocks->map(fn (ContentBlock $block) => $this->blockForForm($block))->all();
        }

        return collect(AwardsOpportunityStaticContent::all()['opportunities'] ?? [])
            ->map(fn (array $item) => $this->staticOpportunityForForm($item))
            ->all();
    }

    private function blockForForm(ContentBlock $block): array
    {
        $data = $block->data ?? [];

        return [
            'id' => $block->id,
            'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
            'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
            'category_es' => $block->translations->firstWhere('language.code', 'es')?->subtitle ?? data_get($data, 'category.es', ''),
            'category_en' => $block->translations->firstWhere('language.code', 'en')?->subtitle ?? data_get($data, 'category.en', data_get($data, 'category.es', '')),
            'summary_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
            'summary_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
            'audience_es' => data_get($data, 'audience.es', ''),
            'audience_en' => data_get($data, 'audience.en', data_get($data, 'audience.es', '')),
            'dates_es' => data_get($data, 'dates.es', ''),
            'dates_en' => data_get($data, 'dates.en', data_get($data, 'dates.es', '')),
            'deadline_es' => data_get($data, 'deadline.es', ''),
            'deadline_en' => data_get($data, 'deadline.en', data_get($data, 'deadline.es', '')),
            'location_es' => data_get($data, 'location.es', ''),
            'location_en' => data_get($data, 'location.en', data_get($data, 'location.es', '')),
            'format_es' => data_get($data, 'format.es', ''),
            'format_en' => data_get($data, 'format.en', data_get($data, 'format.es', '')),
            'details_es' => implode("\n", data_get($data, 'details.es', [])),
            'details_en' => implode("\n", data_get($data, 'details.en', data_get($data, 'details.es', []))),
            'benefits_es' => implode("\n", data_get($data, 'benefits.es', [])),
            'benefits_en' => implode("\n", data_get($data, 'benefits.en', data_get($data, 'benefits.es', []))),
            'requirements_es' => implode("\n", data_get($data, 'requirements.es', [])),
            'requirements_en' => implode("\n", data_get($data, 'requirements.en', data_get($data, 'requirements.es', []))),
            'documents_es' => implode("\n", data_get($data, 'documents.es', [])),
            'documents_en' => implode("\n", data_get($data, 'documents.en', data_get($data, 'documents.es', []))),
            'contact' => data_get($data, 'contact', ''),
            'links' => $this->linksForForm(data_get($data, 'links', [])),
        ];
    }

    private function staticOpportunityForForm(array $item): array
    {
        return [
            'id' => null,
            'title_es' => data_get($item, 'title.es', ''),
            'title_en' => data_get($item, 'title.en', data_get($item, 'title.es', '')),
            'category_es' => data_get($item, 'category.es', ''),
            'category_en' => data_get($item, 'category.en', data_get($item, 'category.es', '')),
            'audience_es' => data_get($item, 'audience.es', ''),
            'audience_en' => data_get($item, 'audience.en', data_get($item, 'audience.es', '')),
            'summary_es' => data_get($item, 'summary.es', ''),
            'summary_en' => data_get($item, 'summary.en', data_get($item, 'summary.es', '')),
            'dates_es' => data_get($item, 'dates.es', ''),
            'dates_en' => data_get($item, 'dates.en', data_get($item, 'dates.es', '')),
            'deadline_es' => data_get($item, 'deadline.es', ''),
            'deadline_en' => data_get($item, 'deadline.en', data_get($item, 'deadline.es', '')),
            'location_es' => data_get($item, 'location.es', ''),
            'location_en' => data_get($item, 'location.en', data_get($item, 'location.es', '')),
            'format_es' => data_get($item, 'format.es', ''),
            'format_en' => data_get($item, 'format.en', data_get($item, 'format.es', '')),
            'details_es' => $this->localizedListForForm($item['details'] ?? [], 'es'),
            'details_en' => $this->localizedListForForm($item['details'] ?? [], 'en'),
            'benefits_es' => $this->localizedListForForm($item['benefits'] ?? [], 'es'),
            'benefits_en' => $this->localizedListForForm($item['benefits'] ?? [], 'en'),
            'requirements_es' => $this->localizedListForForm($item['requirements'] ?? [], 'es'),
            'requirements_en' => $this->localizedListForForm($item['requirements'] ?? [], 'en'),
            'documents_es' => $this->localizedListForForm($item['documents'] ?? [], 'es'),
            'documents_en' => $this->localizedListForForm($item['documents'] ?? [], 'en'),
            'contact' => $item['contact'] ?? '',
            'links' => $this->linksForForm($item['links'] ?? []),
        ];
    }

    private function syncOpportunities(Section $section, array $opportunities, $languages): void
    {
        $keptIds = [];

        foreach ($opportunities as $index => $opportunity) {
            $block = $opportunity['id']
                ? ContentBlock::query()->where('section_id', $section->id)->whereKey($opportunity['id'])->first()
                : null;

            $data = [
                'category' => $opportunity['category'],
                'audience' => $opportunity['audience'],
                'dates' => $opportunity['dates'],
                'deadline' => $opportunity['deadline'],
                'location' => $opportunity['location'],
                'format' => $opportunity['format'],
                'details' => $opportunity['details'],
                'benefits' => $opportunity['benefits'],
                'requirements' => $opportunity['requirements'],
                'documents' => $opportunity['documents'],
                'links' => $opportunity['links'],
                'contact' => $opportunity['contact'],
                'locked_design' => true,
            ];

            $values = [
                'section_id' => $section->id,
                'block_type' => 'awards_opportunity',
                'sort_order' => $index + 1,
                'is_active' => true,
                'link_url' => 'awards-opportunity.'.($block?->id ?? Str::uuid()),
                'data' => $data,
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
                        'title' => $opportunity['title'][$locale],
                        'subtitle' => $opportunity['category'][$locale],
                        'summary' => $opportunity['summary'][$locale],
                        'body' => null,
                    ]
                );
            }
        }

        $section->contentBlocks()
            ->where('block_type', 'awards_opportunity')
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

    private function validatedLinks(array $rows): array
    {
        return collect($rows)
            ->filter(fn ($row) => filled($row['label_es'] ?? null) || filled($row['label_en'] ?? null) || filled($row['href'] ?? null))
            ->map(function (array $row): ?array {
                $labelEs = trim($row['label_es'] ?? '');
                $href = trim($row['href'] ?? '');

                if ($labelEs === '' || $href === '') {
                    return null;
                }

                return [
                    'label' => $this->localized($labelEs, trim($row['label_en'] ?? '')),
                    'href' => $href,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private function linksForForm(array $links): array
    {
        return collect($links)->map(fn ($link) => [
            'label_es' => data_get($link, 'label.es', ''),
            'label_en' => data_get($link, 'label.en', data_get($link, 'label.es', '')),
            'href' => data_get($link, 'href', ''),
        ])->all();
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

    private function localizedLines(string $es, string $en): array
    {
        $esList = $this->linesToList($es);
        $enList = $this->linesToList($en);

        return ['es' => $esList, 'en' => $enList !== [] ? $enList : $esList];
    }

    private function localizedListForForm(array $items, string $locale): string
    {
        return collect($items)
            ->map(fn ($item) => data_get($item, $locale, data_get($item, 'es', '')))
            ->filter()
            ->implode("\n");
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
        abort_unless($page->slug === 'premios-eventos-cursos-concursos', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403);
    }
}
