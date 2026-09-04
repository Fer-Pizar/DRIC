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
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsContentController extends Controller
{
    private const MAX_IMAGE_KB = 10240;
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

    public function editDetail(ContentBlock $news): View
    {
        $this->authorizeNewsBlockAccess($news);

        $news->load(['translations.language']);

        return view('admin.pages.news-detail-content', [
            'news' => $news,
            'content' => $this->detailContent($news),
            'images' => $this->galleryImages($news),
            'newsPage' => $news->section->page,
        ]);
    }

    public function updateDetail(Request $request, ContentBlock $news): RedirectResponse
    {
        $this->authorizeNewsBlockAccess($news);

        $validated = Validator::make($request->all(), [
            'es.detail_title' => ['nullable', 'string', 'max:180'],
            'en.detail_title' => ['nullable', 'string', 'max:180'],
            'es.deck' => ['nullable', 'string', 'max:900'],
            'en.deck' => ['nullable', 'string', 'max:900'],
            'es.body' => ['nullable', 'string', 'max:20000'],
            'en.body' => ['nullable', 'string', 'max:20000'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ], [
            'images.*.image' => 'Solo puedes subir imágenes válidas.',
            'images.*.mimes' => 'Ese formato no está permitido. Usa JPG o PNG.',
            'images.*.max' => 'La imagen sobrepasa los 10MB.',
            'max' => 'Este campo supera el tamaño permitido.',
        ])->validate();

        DB::transaction(function () use ($request, $validated, $news): void {
            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $removeIds = collect($validated['remove_images'] ?? [])->map(fn ($id) => (int) $id)->all();
            $gallery = collect($this->galleryImages($news))
                ->reject(function (array $image) use ($removeIds): bool {
                    if (! in_array((int) $image['media_asset_id'], $removeIds, true)) {
                        return false;
                    }

                    $media = MediaAsset::find($image['media_asset_id']);
                    if ($media) {
                        Storage::disk($media->disk ?? 'public')->delete($media->file_path);
                        $media->delete();
                    }

                    return true;
                })
                ->values()
                ->all();

            foreach ($request->file('images', []) as $file) {
                $media = $this->storeMediaFile($file, $request->user()->id);
                $gallery[] = [
                    'media_asset_id' => $media->id,
                    'url' => '/storage/'.ltrim($media->file_path, '/'),
                    'file_name' => $media->file_name,
                ];
            }

            $data = $news->data ?? [];
            $data['detail_title_es'] = trim($validated['es']['detail_title'] ?? '');
            $data['detail_title_en'] = trim($validated['en']['detail_title'] ?? '') ?: $data['detail_title_es'];
            $data['deck_es'] = trim($validated['es']['deck'] ?? '');
            $data['deck_en'] = trim($validated['en']['deck'] ?? '') ?: $data['deck_es'];
            $data['images'] = $gallery;
            $news->update(['data' => $data]);

            foreach (['es', 'en'] as $locale) {
                $body = $this->sanitizeRichText($validated[$locale]['body'] ?? '');
                if ($locale === 'en' && $body === '') {
                    $body = $this->sanitizeRichText($validated['es']['body'] ?? '');
                }

                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $news->id, 'language_id' => $languages[$locale]->id],
                    ['body' => $body ?: null]
                );
            }
        });

        return redirect()
            ->route('admin.news.detail.edit', $news)
            ->with('success', 'El detalle de la noticia fue actualizado correctamente.');
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
                'news.*.href' => ['nullable', 'string', 'max:900'],
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
                'news.*.href.max' => 'El enlace es demasiado largo.',
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
            ->map(function ($row) {
                $titleEs = trim($row['title_es']);
                $href = trim($row['href'] ?? '');
                $slug = $this->slugFromHref($href) ?: Str::slug($titleEs);

                return [
                    'id' => isset($row['id']) ? (int) $row['id'] : null,
                    'is_active' => (bool) ($row['is_active'] ?? false),
                    'title_es' => $titleEs,
                    'title_en' => trim($row['title_en'] ?? '') ?: $titleEs,
                    'category_es' => trim($row['category_es']),
                    'category_en' => trim($row['category_en'] ?? '') ?: trim($row['category_es']),
                    'date_es' => trim($row['date_es']),
                    'date_en' => trim($row['date_en'] ?? '') ?: trim($row['date_es']),
                    'published_at' => $row['published_at'],
                    'excerpt_es' => trim($row['excerpt_es']),
                    'excerpt_en' => trim($row['excerpt_en'] ?? '') ?: trim($row['excerpt_es']),
                    'slug' => $slug,
                    'href' => filter_var($href, FILTER_VALIDATE_URL) ? $href : '/noticias/'.$slug,
                ];
            })
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

            $data = $block->data ?? [];
            $data['slug'] = $item['slug'];
            $data['href'] = $item['href'];
            $data['published_at'] = $item['published_at'];

            $block->fill([
                'block_type' => 'news_item',
                'sort_order' => $index + 1,
                'is_active' => $item['is_active'],
                'data' => $data,
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

    private function detailContent(ContentBlock $news): array
    {
        $data = $news->data ?? [];

        return [
            'es' => [
                'detail_title' => is_string($data['detail_title_es'] ?? null) ? $data['detail_title_es'] : '',
                'deck' => is_string($data['deck_es'] ?? null) ? $data['deck_es'] : '',
                'body' => $news->translations->firstWhere('language.code', 'es')?->body ?? '',
            ],
            'en' => [
                'detail_title' => is_string($data['detail_title_en'] ?? null) ? $data['detail_title_en'] : '',
                'deck' => is_string($data['deck_en'] ?? null) ? $data['deck_en'] : '',
                'body' => $news->translations->firstWhere('language.code', 'en')?->body ?? '',
            ],
        ];
    }

    private function galleryImages(ContentBlock $news): array
    {
        $images = $news->data['images'] ?? [];

        return is_array($images) ? array_values(array_filter($images, fn ($image) => is_array($image))) : [];
    }

    private function storeMediaFile($file, ?int $userId): MediaAsset
    {
        $path = $file->store('news', 'public');
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
                ['alt_text' => $media->file_name, 'caption' => null]
            );
        }

        return $media;
    }

    private function sanitizeRichText(string $html): string
    {
        $html = trim($html);
        $html = $this->normalizeRichText($html);
        $html = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $html) ?? '';
        $html = strip_tags($html, '<p><br><strong><b><em><i><u><ul><ol><li><blockquote><h2><h3><a>');
        $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? '';
        $html = preg_replace('/href\s*=\s*([\'"])\s*javascript:[^\'"]*\1/i', 'href="#"', $html) ?? '';
        $html = $this->repairListMarkup($html);

        return trim($html);
    }

    private function normalizeRichText(string $html): string
    {
        if (preg_match('/<(p|h2|h3|ul|ol|li|blockquote)\b/i', $html)) {
            return $html;
        }

        $parts = preg_split('/(?:<br\s*\/?>|\R){2,}/i', $html) ?: [];
        $paragraphs = collect($parts)
            ->map(fn (string $part) => trim($part))
            ->filter()
            ->map(fn (string $part) => '<p>'.preg_replace('/(?:<br\s*\/?>|\R)+/i', '<br>', $part).'</p>')
            ->implode('');

        return $paragraphs ?: $html;
    }

    private function repairListMarkup(string $html): string
    {
        $html = preg_replace('/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>).*?(?:<\/ul>|<\/ol>))\s*<\/p>/is', '$1', $html) ?? $html;
        $html = preg_replace('/<p>\s*(<ul\b[^>]*>)/i', '$1', $html) ?? $html;
        $html = preg_replace('/(<\/ul>|<\/ol>)\s*<\/p>/i', '$1', $html) ?? $html;
        $html = preg_replace('/<\/li>\s*<br\s*\/?>/i', '</li>', $html) ?? $html;

        return $html;
    }

    private function slugFromHref(string $href): ?string
    {
        if (! Str::startsWith($href, ['/noticias/', '/es/noticias/', '/en/noticias/'])) {
            return null;
        }

        $slug = Str::after($href, '/noticias/');
        $slug = Str::after($slug, '/es/noticias/');
        $slug = Str::after($slug, '/en/noticias/');

        return $slug !== '' ? Str::slug($slug) : null;
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

    private function authorizeNewsBlockAccess(ContentBlock $news): void
    {
        $news->loadMissing('section.page');
        abort_unless($news->block_type === 'news_item' && $news->section?->section_key === 'news.list', 404);
        abort_unless($news->section?->page?->slug === 'noticias', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $news->section->page), 403, 'No tienes permiso para editar esta noticia.');
    }
}
