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

class NewsContentController extends Controller
{
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeNewsAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.news-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'newsItems' => $this->newsItems($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeNewsAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $newsItems = $this->validatedNewsItems($request);

        DB::transaction(function () use ($request, $validated, $newsItems, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'news.hero', 'news_hero', 1);
            $list = $this->upsertSection($page, 'news.list', 'news_list', 2);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => 'DRIC · UMSS',
                        'summary' => $validated[$locale]['summary'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => 'DRIC · UMSS',
                        'summary' => $validated[$locale]['summary'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $list->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['section_title'],
                        'subtitle' => $validated[$locale]['kicker'],
                        'summary' => $validated[$locale]['search_placeholder'],
                        'body' => $validated[$locale]['read_more_label'],
                    ]
                );
            }

            $this->syncNewsItems($request, $list, $this->sortNewsItems($newsItems), $languages);
        });

        return redirect()
            ->route('admin.pages.news.edit', $page)
            ->with('success', 'El contenido de Noticias fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.summary"] = ['required', 'string', 'max:900'];
            $localized["{$locale}.kicker"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.section_title"] = ['required', 'string', 'max:180'];
            $localized["{$locale}.search_placeholder"] = ['required', 'string', 'max:120'];
            $localized["{$locale}.read_more_label"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
        }

        return $localized;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/noticia',
            'date' => 'Ingresa una fecha válida.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function validatedNewsItems(Request $request): array
    {
        $rows = collect($request->input('news', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['excerpt_es'] ?? null) || filled($row['href'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['news' => $rows],
            [
                'news' => ['array'],
                'news.*.id' => ['nullable', 'integer'],
                'news.*.is_active' => ['nullable', 'boolean'],
                'news.*.title_es' => ['required', 'string', 'max:220'],
                'news.*.title_en' => ['nullable', 'string', 'max:220'],
                'news.*.category_es' => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
                'news.*.category_en' => ['nullable', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
                'news.*.date_es' => ['required', 'string', 'max:80'],
                'news.*.date_en' => ['nullable', 'string', 'max:80'],
                'news.*.published_at' => ['required', 'date'],
                'news.*.excerpt_es' => ['required', 'string', 'max:700'],
                'news.*.excerpt_en' => ['nullable', 'string', 'max:700'],
                'news.*.href' => ['required', 'string', 'max:900'],
            ],
            [
                'news.*.title_es.required' => 'Escribe el título de la noticia.',
                'news.*.category_es.required' => 'Escribe la categoría de la noticia.',
                'news.*.category_es.regex' => 'La categoría solo puede contener letras, espacios, puntos y comas.',
                'news.*.category_en.regex' => 'La categoría en inglés solo puede contener letras, espacios, puntos y comas.',
                'news.*.date_es.required' => 'Escribe la fecha visible.',
                'news.*.published_at.required' => 'Selecciona la fecha de publicación.',
                'news.*.published_at.date' => 'Selecciona una fecha de publicación válida.',
                'news.*.excerpt_es.required' => 'Escribe el resumen de la noticia.',
                'news.*.href.required' => 'Ingresa el enlace de la noticia.',
            ]
        );

        $validator->after(function ($validator) use ($rows): void {
            foreach ($rows as $index => $row) {
                $href = trim($row['href'] ?? '');

                if ($href === '') {
                    continue;
                }

                if (! Str::startsWith($href, ['/']) && ! filter_var($href, FILTER_VALIDATE_URL)) {
                    $validator->errors()->add("news.{$index}.href", 'Ingresa una URL completa o una ruta interna que empiece con /.');
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['news'] ?? [])
            ->map(fn ($row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'is_active' => (bool) ($row['is_active'] ?? false),
                'title_es' => trim($row['title_es']),
                'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                'category_es' => trim($row['category_es']),
                'category_en' => trim($row['category_en'] ?? '') ?: trim($row['category_es']),
                'date_es' => trim($row['date_es']),
                'date_en' => trim($row['date_en'] ?? '') ?: trim($row['date_es']),
                'published_at' => $row['published_at'],
                'excerpt_es' => trim($row['excerpt_es']),
                'excerpt_en' => trim($row['excerpt_en'] ?? '') ?: trim($row['excerpt_es']),
                'href' => trim($row['href']),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'title' => $this->pageValue($page, 'es', 'title', 'Noticias'),
                'summary' => $this->sectionValue($page, 'news.hero', 'es', 'summary', 'Noticias institucionales, movilidad académica, cooperación internacional y actividades destacadas de la DRIC.'),
                'kicker' => $this->sectionValue($page, 'news.list', 'es', 'subtitle', 'Explorar'),
                'section_title' => $this->sectionValue($page, 'news.list', 'es', 'title', 'Últimas noticias institucionales'),
                'search_placeholder' => $this->sectionValue($page, 'news.list', 'es', 'summary', 'Buscar noticias...'),
                'read_more_label' => $this->sectionValue($page, 'news.list', 'es', 'body', 'Leer más'),
            ],
            'en' => [
                'title' => $this->pageValue($page, 'en', 'title', 'News'),
                'summary' => $this->sectionValue($page, 'news.hero', 'en', 'summary', 'Institutional news, academic mobility updates, international cooperation activities and opportunities from DRIC.'),
                'kicker' => $this->sectionValue($page, 'news.list', 'en', 'subtitle', 'Explore'),
                'section_title' => $this->sectionValue($page, 'news.list', 'en', 'title', 'Latest institutional updates'),
                'search_placeholder' => $this->sectionValue($page, 'news.list', 'en', 'summary', 'Search news...'),
                'read_more_label' => $this->sectionValue($page, 'news.list', 'en', 'body', 'Read more'),
            ],
        ];
    }

    private function newsItems(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'news.list');

        return ($section?->contentBlocks ?? collect())
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'is_active' => (bool) $block->is_active,
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'category_es' => $block->translations->firstWhere('language.code', 'es')?->subtitle ?? '',
                'category_en' => $block->translations->firstWhere('language.code', 'en')?->subtitle ?? '',
                'date_es' => $block->translations->firstWhere('language.code', 'es')?->cta_label ?? '',
                'date_en' => $block->translations->firstWhere('language.code', 'en')?->cta_label ?? '',
                'published_at' => $block->data['published_at'] ?? now()->toDateString(),
                'excerpt_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'excerpt_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
                'href' => is_string($block->data['href'] ?? null) ? $block->data['href'] : '',
            ])
            ->all();
    }

    private function syncNewsItems(Request $request, Section $section, array $newsItems, $languages): void
    {
        $keptIds = [];

        foreach ($newsItems as $index => $item) {
            $block = $item['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $item['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'news.item.'.Str::uuid()->toString(),
                ]);
            }

            $block->fill([
                'block_type' => 'news_item',
                'sort_order' => $index + 1,
                'is_active' => $item['is_active'],
                'data' => [
                    'href' => $item['href'],
                    'published_at' => $item['published_at'],
                ],
            ]);

            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $item['title_es'] : $item['title_en'],
                        'subtitle' => $locale === 'es' ? $item['category_es'] : $item['category_en'],
                        'summary' => $locale === 'es' ? $item['excerpt_es'] : $item['excerpt_en'],
                        'body' => null,
                        'cta_label' => $locale === 'es' ? $item['date_es'] : $item['date_en'],
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }

    private function sortNewsItems(array $newsItems): array
    {
        return collect($newsItems)
            ->sortByDesc(fn (array $item) => $item['published_at'])
            ->values()
            ->all();
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

    private function authorizeNewsAccess(Page $page): void
    {
        abort_unless($page->slug === 'noticias', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
