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
use App\Support\NationalForeignInfoStaticContent;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NationalForeignInfoContentController extends Controller
{
    private const MAX_IMAGE_KB = 7168;
    private const MAX_PDF_KB = 20480;

    public function edit(Page $page): View
    {
        $this->authorizeAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.national-foreign-info-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'sections' => $this->sectionCards($page),
            'hubPage' => Page::query()->where('slug', 'becas-movilidad')->first(),
            'frontendUrl' => rtrim((string) config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/'),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $cards = $this->validatedCards($request);

        DB::transaction(function () use ($request, $validated, $cards, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'national_foreign_info.hero', 'national_foreign_info_hero', 1);
            $list = $this->upsertSection($page, 'national_foreign_info.sections', 'national_foreign_info_sections', 2);

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

                SectionTranslation::updateOrCreate(
                    ['section_id' => $list->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['key_info'],
                        'subtitle' => $validated[$locale]['resources'],
                        'summary' => $validated[$locale]['photo_slot'],
                        'body' => $validated[$locale]['open'],
                    ]
                );
            }

            $this->syncCards($request, $list, $cards, $languages);
        });

        return redirect()
            ->route('admin.pages.national-foreign-info.edit', $page)
            ->with('success', 'El contenido de Información para nacionales y extranjeros fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [
            'sections.*.image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'sections.*.links.*.pdf' => ['nullable', 'file', 'mimes:pdf', 'max:'.self::MAX_PDF_KB],
        ];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.menu_title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.eyebrow"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:220'];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:1200'];
            $rules["{$locale}.key_info"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.resources"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.open"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.photo_slot"] = ['required', 'string', 'max:140'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://www.umss.edu.bo',
            'max' => 'Este campo supera el tamaño permitido.',
            'sections.*.image.file' => 'Debes subir un archivo válido.',
            'sections.*.image.image' => 'El archivo debe ser una imagen.',
            'sections.*.image.mimes' => 'Ese formato no está permitido. Sube una imagen JPG o PNG.',
            'sections.*.image.max' => 'La imagen sobrepasa los 7MB.',
            'sections.*.links.*.pdf.file' => 'Debes subir un PDF válido.',
            'sections.*.links.*.pdf.mimes' => 'Ese formato no está permitido. Sube un documento PDF.',
            'sections.*.links.*.pdf.max' => 'El PDF sobrepasa los 20MB.',
        ];
    }

    private function validatedCards(Request $request): array
    {
        $rows = collect($request->input('sections', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['summary_es'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['sections' => $rows],
            [
                'sections' => ['array'],
                'sections.*.id' => ['nullable', 'integer'],
                'sections.*.key' => ['nullable', 'string', 'max:120'],
                'sections.*.title_es' => ['required', 'string', 'max:220'],
                'sections.*.title_en' => ['nullable', 'string', 'max:220'],
                'sections.*.eyebrow_es' => ['required', 'string', 'max:180'],
                'sections.*.eyebrow_en' => ['nullable', 'string', 'max:180'],
                'sections.*.summary_es' => ['required', 'string', 'max:1400'],
                'sections.*.summary_en' => ['nullable', 'string', 'max:1400'],
                'sections.*.image_alt_es' => ['required', 'string', 'max:220'],
                'sections.*.image_alt_en' => ['nullable', 'string', 'max:220'],
                'sections.*.existing_image' => ['nullable', 'string', 'max:900'],
                'sections.*.points_es' => ['required', 'string', 'max:8000'],
                'sections.*.points_en' => ['nullable', 'string', 'max:8000'],
                'sections.*.links' => ['nullable', 'array'],
                'sections.*.links.*.label_es' => ['nullable', 'string', 'max:240'],
                'sections.*.links.*.label_en' => ['nullable', 'string', 'max:240'],
                'sections.*.links.*.href' => ['nullable', 'string', 'max:1000'],
                'sections.*.links.*.existing_href' => ['nullable', 'string', 'max:1000'],
            ],
            [
                'sections.*.title_es.required' => 'Escribe el título de esta tarjeta en español.',
                'sections.*.eyebrow_es.required' => 'Escribe la etiqueta superior de esta tarjeta.',
                'sections.*.summary_es.required' => 'Escribe la descripción de esta tarjeta.',
                'sections.*.image_alt_es.required' => 'Escribe un texto alternativo para la imagen.',
                'sections.*.points_es.required' => 'Agrega al menos una viñeta en español.',
                'sections.*.max' => 'Este campo supera el tamaño permitido.',
            ]
        );

        $validator->after(function ($validator) use ($request, $rows): void {
            foreach ($rows as $cardIndex => $row) {
                $links = $row['links'] ?? [];

                foreach ($links as $linkIndex => $link) {
                    $hasLabel = filled($link['label_es'] ?? null) || filled($link['label_en'] ?? null);
                    $hasTarget = filled($link['href'] ?? null)
                        || filled($link['existing_href'] ?? null)
                        || $request->hasFile("sections.{$cardIndex}.links.{$linkIndex}.pdf");

                    if ($hasLabel && ! $hasTarget) {
                        $validator->errors()->add("sections.{$cardIndex}.links.{$linkIndex}.href", 'Agrega una URL o sube un PDF para este recurso.');
                    }

                    if (! $hasLabel && $hasTarget) {
                        $validator->errors()->add("sections.{$cardIndex}.links.{$linkIndex}.label_es", 'Escribe el texto visible del recurso en español.');
                    }

                    if (filled($link['href'] ?? null) && ! filter_var($link['href'], FILTER_VALIDATE_URL) && ! Str::startsWith($link['href'], ['/storage/'])) {
                        $validator->errors()->add("sections.{$cardIndex}.links.{$linkIndex}.href", 'Ingresa una URL válida o sube un PDF.');
                    }
                }
            }
        });

        return collect($validator->validate()['sections'] ?? [])
            ->map(fn (array $row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'key' => trim($row['key'] ?? ''),
                'title' => $this->localized(trim($row['title_es']), trim($row['title_en'] ?? '')),
                'eyebrow' => $this->localized(trim($row['eyebrow_es']), trim($row['eyebrow_en'] ?? '')),
                'summary' => $this->localized(trim($row['summary_es']), trim($row['summary_en'] ?? '')),
                'image_alt' => $this->localized(trim($row['image_alt_es']), trim($row['image_alt_en'] ?? '')),
                'existing_image' => trim($row['existing_image'] ?? ''),
                'points' => $this->localizedLines($row['points_es'] ?? '', $row['points_en'] ?? ''),
                'links' => $this->validatedLinks($row['links'] ?? []),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        $fallback = NationalForeignInfoStaticContent::all()['copy'] ?? [];

        return [
            'es' => [
                'menu_title' => $this->pageValue($page, 'es', 'menu_title', data_get($fallback, 'es.title', 'Información para nacionales y extranjeros')),
                'eyebrow' => $this->sectionValue($page, 'national_foreign_info.hero', 'es', 'subtitle', data_get($fallback, 'es.eyebrow', 'Información de interés')),
                'title' => $this->pageValue($page, 'es', 'title', data_get($fallback, 'es.title', 'Información para nacionales y extranjeros')),
                'intro' => $this->sectionValue($page, 'national_foreign_info.hero', 'es', 'summary', data_get($fallback, 'es.intro', 'Guía esencial para procesos de movilidad vinculados con la UMSS.')),
                'key_info' => $this->sectionValue($page, 'national_foreign_info.sections', 'es', 'title', data_get($fallback, 'es.keyInfo', 'Información clave')),
                'resources' => $this->sectionValue($page, 'national_foreign_info.sections', 'es', 'subtitle', data_get($fallback, 'es.resources', 'Recursos oficiales')),
                'open' => $this->sectionValue($page, 'national_foreign_info.sections', 'es', 'body', data_get($fallback, 'es.open', 'Abrir enlace')),
                'photo_slot' => $this->sectionValue($page, 'national_foreign_info.sections', 'es', 'summary', data_get($fallback, 'es.photoSlot', 'Espacio reservado para imagen')),
            ],
            'en' => [
                'menu_title' => $this->pageValue($page, 'en', 'menu_title', data_get($fallback, 'en.title', 'Information for nationals and foreigners')),
                'eyebrow' => $this->sectionValue($page, 'national_foreign_info.hero', 'en', 'subtitle', data_get($fallback, 'en.eyebrow', 'Useful information')),
                'title' => $this->pageValue($page, 'en', 'title', data_get($fallback, 'en.title', 'Information for nationals and foreigners')),
                'intro' => $this->sectionValue($page, 'national_foreign_info.hero', 'en', 'summary', data_get($fallback, 'en.intro', 'Essential guidance for mobility processes linked to UMSS.')),
                'key_info' => $this->sectionValue($page, 'national_foreign_info.sections', 'en', 'title', data_get($fallback, 'en.keyInfo', 'Key information')),
                'resources' => $this->sectionValue($page, 'national_foreign_info.sections', 'en', 'subtitle', data_get($fallback, 'en.resources', 'Official resources')),
                'open' => $this->sectionValue($page, 'national_foreign_info.sections', 'en', 'body', data_get($fallback, 'en.open', 'Open link')),
                'photo_slot' => $this->sectionValue($page, 'national_foreign_info.sections', 'en', 'summary', data_get($fallback, 'en.photoSlot', 'Reserved image space')),
            ],
        ];
    }

    private function sectionCards(Page $page): array
    {
        $blocks = $page->sections
            ->firstWhere('section_key', 'national_foreign_info.sections')
            ?->contentBlocks
            ->where('block_type', 'national_foreign_info_section')
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values();

        if ($blocks && $blocks->isNotEmpty()) {
            return $blocks->map(fn (ContentBlock $block) => $this->blockForForm($block))->all();
        }

        return collect(NationalForeignInfoStaticContent::all()['sections'] ?? [])
            ->map(fn (array $section) => $this->staticSectionForForm($section))
            ->all();
    }

    private function blockForForm(ContentBlock $block): array
    {
        $data = $block->data ?? [];
        $image = $block->mediaAsset?->file_path ? '/storage/'.ltrim($block->mediaAsset->file_path, '/') : data_get($data, 'image', '');

        return [
            'id' => $block->id,
            'key' => data_get($data, 'id', Str::slug($block->translations->firstWhere('language.code', 'es')?->title ?? 'tarjeta')),
            'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
            'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
            'eyebrow_es' => data_get($data, 'eyebrow.es', $block->translations->firstWhere('language.code', 'es')?->subtitle ?? ''),
            'eyebrow_en' => data_get($data, 'eyebrow.en', data_get($data, 'eyebrow.es', '')),
            'summary_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
            'summary_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
            'image' => $image,
            'image_alt_es' => data_get($data, 'image_alt.es', ''),
            'image_alt_en' => data_get($data, 'image_alt.en', data_get($data, 'image_alt.es', '')),
            'points_es' => implode("\n", data_get($data, 'points.es', [])),
            'points_en' => implode("\n", data_get($data, 'points.en', data_get($data, 'points.es', []))),
            'links' => collect(data_get($data, 'links', []))->map(fn (array $link) => [
                'label_es' => data_get($link, 'label.es', ''),
                'label_en' => data_get($link, 'label.en', data_get($link, 'label.es', '')),
                'href' => data_get($link, 'href', ''),
            ])->all(),
        ];
    }

    private function staticSectionForForm(array $section): array
    {
        return [
            'id' => null,
            'key' => $section['id'] ?? Str::slug(data_get($section, 'title.es', 'tarjeta')),
            'title_es' => data_get($section, 'title.es', ''),
            'title_en' => data_get($section, 'title.en', data_get($section, 'title.es', '')),
            'eyebrow_es' => data_get($section, 'eyebrow.es', ''),
            'eyebrow_en' => data_get($section, 'eyebrow.en', data_get($section, 'eyebrow.es', '')),
            'summary_es' => data_get($section, 'summary.es', ''),
            'summary_en' => data_get($section, 'summary.en', data_get($section, 'summary.es', '')),
            'image' => data_get($section, 'image', ''),
            'image_alt_es' => data_get($section, 'imageAlt.es', ''),
            'image_alt_en' => data_get($section, 'imageAlt.en', data_get($section, 'imageAlt.es', '')),
            'points_es' => collect($section['points'] ?? [])->map(fn ($point) => $point['es'] ?? null)->filter()->implode("\n"),
            'points_en' => collect($section['points'] ?? [])->map(fn ($point) => $point['en'] ?? ($point['es'] ?? null))->filter()->implode("\n"),
            'links' => collect($section['links'] ?? [])->map(fn ($link) => [
                'label_es' => data_get($link, 'label.es', ''),
                'label_en' => data_get($link, 'label.en', data_get($link, 'label.es', '')),
                'href' => data_get($link, 'href', ''),
            ])->all(),
        ];
    }

    private function syncCards(Request $request, Section $section, array $cards, $languages): void
    {
        $keptIds = [];

        foreach ($cards as $index => $card) {
            $block = $card['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $card['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'national-foreign-info.'.Str::uuid()->toString(),
                ]);
            }

            $links = [];

            foreach ($card['links'] as $linkIndex => $link) {
                $href = $link['href'];

                if ($request->hasFile("sections.{$index}.links.{$linkIndex}.pdf")) {
                    $href = '/storage/'.ltrim($this->storeMedia($request, "sections.{$index}.links.{$linkIndex}.pdf", 'national-foreign-info/documents')->file_path, '/');
                }

                $links[] = [
                    'label' => $link['label'],
                    'href' => $href,
                ];
            }

            $data = [
                'id' => $card['key'] ?: Str::slug($card['title']['es']),
                'eyebrow' => $card['eyebrow'],
                'image' => $card['existing_image'],
                'image_alt' => $card['image_alt'],
                'points' => $card['points'],
                'links' => $links,
                'locked_design' => true,
            ];

            $block->fill([
                'block_type' => 'national_foreign_info_section',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => $data,
            ]);

            if ($request->hasFile("sections.{$index}.image")) {
                $block->media_asset_id = $this->storeMedia($request, "sections.{$index}.image", 'national-foreign-info/images')->id;
            }

            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $card['title'][$locale],
                        'subtitle' => $card['eyebrow'][$locale],
                        'summary' => $card['summary'][$locale],
                        'body' => null,
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
            ->where('block_type', 'national_foreign_info_section')
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->with('mediaAsset')
            ->get()
            ->each(function (ContentBlock $block): void {
                if ($block->mediaAsset) {
                    Storage::disk($block->mediaAsset->disk ?? 'public')->delete($block->mediaAsset->file_path);
                    $block->mediaAsset->delete();
                }

                $block->delete();
            });
    }

    private function validatedLinks(array $links): array
    {
        return collect($links)
            ->filter(fn ($link) => filled($link['label_es'] ?? null) || filled($link['label_en'] ?? null) || filled($link['href'] ?? null) || filled($link['existing_href'] ?? null))
            ->map(function (array $link) {
                $href = trim($link['href'] ?? '') ?: trim($link['existing_href'] ?? '');

                return [
                    'label' => $this->localized(trim($link['label_es'] ?? ''), trim($link['label_en'] ?? '')),
                    'href' => $href,
                ];
            })
            ->values()
            ->all();
    }

    private function localized(string $es, string $en): array
    {
        return ['es' => $es, 'en' => $en !== '' ? $en : $es];
    }

    private function localizedLines(string $es, string $en): array
    {
        $esLines = $this->lines($es);
        $enLines = $this->lines($en);

        return ['es' => $esLines, 'en' => $enLines !== [] ? $enLines : $esLines];
    }

    private function lines(string $value): array
    {
        return collect(preg_split('/\R/u', $value) ?: [])
            ->map(fn ($line) => trim((string) preg_replace('/^\s*[-*•]\s*/u', '', $line)))
            ->filter()
            ->values()
            ->all();
    }

    private function storeMedia(Request $request, string $field, string $prefix): MediaAsset
    {
        $file = $request->file($field);
        $path = $file->store($prefix, 'public');

        $media = MediaAsset::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'disk' => 'public',
            'uploaded_by' => $request->user()->id,
        ]);

        foreach (Language::query()->whereIn('code', ['es', 'en'])->get() as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                ['alt_text' => 'Archivo de información para nacionales y extranjeros', 'caption' => null]
            );
        }

        return $media;
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

    private function authorizeAccess(Page $page): void
    {
        abort_unless($page->slug === 'informacion-nacionales-extranjeros', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
