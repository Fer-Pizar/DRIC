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

class MembershipContentController extends Controller
{
    private const MAX_IMAGE_KB = 5120;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeMembershipAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.membership-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'memberships' => $this->memberships($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeMembershipAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $memberships = $this->validatedMemberships($request);

        DB::transaction(function () use ($request, $validated, $memberships, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'memberships.hero', 'memberships_hero', 1);
            $list = $this->upsertSection($page, 'memberships.list', 'membership_list', 2);
            $info = $this->upsertSection($page, 'memberships.info', 'memberships_info', 3);

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
                        'summary' => null,
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $info->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['info_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['info_text'],
                        'body' => null,
                    ]
                );
            }

            $this->syncMemberships($request, $list, $memberships, $languages);
        });

        return redirect()
            ->route('admin.pages.memberships.edit', $page)
            ->with('success', 'El contenido de Membresías fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.summary"] = ['required', 'string', 'max:900'];
            $localized["{$locale}.kicker"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.section_title"] = ['required', 'string', 'max:180'];
            $localized["{$locale}.info_title"] = ['required', 'string', 'max:140'];
            $localized["{$locale}.info_text"] = ['required', 'string', 'max:800'];
        }

        return array_merge($localized, [
            'memberships.*.image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
        ]);
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'file' => 'Debes subir un archivo válido.',
            'mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'memberships.*.image.max' => 'La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.',
        ];
    }

    private function validatedMemberships(Request $request): array
    {
        $rows = collect($request->input('memberships', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['description_es'] ?? null) || filled($row['url'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['memberships' => $rows],
            [
                'memberships' => ['array'],
                'memberships.*.id' => ['nullable', 'integer'],
                'memberships.*.title_es' => ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX],
                'memberships.*.title_en' => ['nullable', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX],
                'memberships.*.description_es' => ['required', 'string', 'max:800'],
                'memberships.*.description_en' => ['nullable', 'string', 'max:800'],
                'memberships.*.extra_info_enabled' => ['nullable', 'boolean'],
                'memberships.*.pador_text_es' => ['nullable', 'string', 'max:400'],
                'memberships.*.pador_text_en' => ['nullable', 'string', 'max:400'],
                'memberships.*.extra_info_email' => ['nullable', 'email', 'max:180'],
                'memberships.*.url' => ['nullable', 'url', 'max:900'],
                'memberships.*.existing_image' => ['nullable', 'string', 'max:900'],
            ],
            [
                'memberships.*.title_es.required' => 'Escribe el título de la membresía.',
                'memberships.*.title_es.regex' => 'El título solo puede contener letras, espacios, puntos y comas.',
                'memberships.*.title_en.regex' => 'El título en inglés solo puede contener letras, espacios, puntos y comas.',
                'memberships.*.description_es.required' => 'Escribe una descripción corta.',
                'memberships.*.pador_text_es.max' => 'El texto especial PADOR es demasiado largo. Usa máximo 400 caracteres.',
                'memberships.*.pador_text_en.max' => 'El texto especial PADOR en inglés es demasiado largo. Usa máximo 400 caracteres.',
                'memberships.*.extra_info_email.email' => 'Ingresa un correo válido, por ejemplo: dric@umss.edu.bo',
                'memberships.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo',
            ]
        );

        $validator->after(function ($validator) use ($rows): void {
            foreach ($rows as $index => $row) {
                if (! (bool) ($row['extra_info_enabled'] ?? false)) {
                    continue;
                }

                if (! filled($row['pador_text_es'] ?? null)) {
                    $validator->errors()->add("memberships.{$index}.pador_text_es", 'Escribe el texto de información extra en español.');
                }

                if (! filled($row['extra_info_email'] ?? null)) {
                    $validator->errors()->add("memberships.{$index}.extra_info_email", 'Escribe el correo de contacto de la información extra.');
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['memberships'] ?? [])
            ->map(function ($row) {
                $extraInfoEnabled = (bool) ($row['extra_info_enabled'] ?? false);

                return [
                    'id' => isset($row['id']) ? (int) $row['id'] : null,
                    'title_es' => trim($row['title_es']),
                    'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                    'description_es' => trim($row['description_es']),
                    'description_en' => trim($row['description_en'] ?? '') ?: trim($row['description_es']),
                    'extra_info_enabled' => $extraInfoEnabled,
                    'pador_text_es' => $extraInfoEnabled ? trim($row['pador_text_es'] ?? '') : '',
                    'pador_text_en' => $extraInfoEnabled ? (trim($row['pador_text_en'] ?? '') ?: trim($row['pador_text_es'] ?? '')) : '',
                    'extra_info_email' => $extraInfoEnabled ? trim($row['extra_info_email'] ?? '') : '',
                    'url' => trim($row['url'] ?? ''),
                    'existing_image' => trim($row['existing_image'] ?? ''),
                ];
            })
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'title' => $this->pageValue($page, 'es', 'title', 'Membresías'),
                'summary' => $this->sectionValue($page, 'memberships.hero', 'es', 'summary', 'La Universidad Mayor de San Simón participa en redes, asociaciones y programas internacionales que fortalecen la cooperación académica, científica e institucional.'),
                'kicker' => $this->sectionValue($page, 'memberships.list', 'es', 'subtitle', 'Redes internacionales'),
                'section_title' => $this->sectionValue($page, 'memberships.list', 'es', 'title', 'Alianzas que conectan a la UMSS con el mundo'),
                'info_title' => $this->sectionValue($page, 'memberships.info', 'es', 'title', 'Información institucional'),
                'info_text' => $this->sectionValue($page, 'memberships.info', 'es', 'summary', 'Para mayor información sobre registros, membresías institucionales o participación en redes internacionales, contactar con la Dirección de Relaciones Internacionales y Convenios.'),
            ],
            'en' => [
                'title' => $this->pageValue($page, 'en', 'title', 'Memberships'),
                'summary' => $this->sectionValue($page, 'memberships.hero', 'en', 'summary', 'Universidad Mayor de San Simón participates in international networks, associations and programs that strengthen academic, scientific and institutional cooperation.'),
                'kicker' => $this->sectionValue($page, 'memberships.list', 'en', 'subtitle', 'International networks'),
                'section_title' => $this->sectionValue($page, 'memberships.list', 'en', 'title', 'Partnerships connecting UMSS with the world'),
                'info_title' => $this->sectionValue($page, 'memberships.info', 'en', 'title', 'Institutional information'),
                'info_text' => $this->sectionValue($page, 'memberships.info', 'en', 'summary', 'For more information about institutional records, memberships or participation in international networks, contact the Directorate of International Relations and Agreements.'),
            ],
        ];
    }

    private function memberships(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'memberships.list');

        return ($section?->contentBlocks ?? collect())
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'description_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'description_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
                'extra_info_enabled' => (bool) ($block->data['extra_info_enabled'] ?? filled($block->translations->firstWhere('language.code', 'es')?->body)),
                'pador_text_es' => $block->translations->firstWhere('language.code', 'es')?->body ?? '',
                'pador_text_en' => $block->translations->firstWhere('language.code', 'en')?->body ?? '',
                'extra_info_email' => is_string($block->data['extra_info_email'] ?? null) ? $block->data['extra_info_email'] : '',
                'url' => is_string($block->data['url'] ?? null) ? $block->data['url'] : '',
                'image' => $block->mediaAsset?->file_path ? '/storage/'.ltrim($block->mediaAsset->file_path, '/') : ($block->data['logo'] ?? ''),
            ])
            ->all();
    }

    private function syncMemberships(Request $request, Section $section, array $memberships, $languages): void
    {
        $keptIds = [];

        foreach ($memberships as $index => $membership) {
            $block = $membership['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $membership['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'memberships.item.'.Str::uuid()->toString(),
                ]);
            }

            $data = [
                'url' => $membership['url'],
                'logo' => $membership['existing_image'],
                'extra_info_enabled' => $membership['extra_info_enabled'],
                'extra_info_email' => $membership['extra_info_email'],
            ];

            $block->fill([
                'block_type' => 'membership_item',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => $data,
            ]);

            if ($request->hasFile("memberships.{$index}.image")) {
                $block->media_asset_id = $this->storeMedia($request, "memberships.{$index}.image", 'memberships')->id;
            }

            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $membership['title_es'] : $membership['title_en'],
                        'subtitle' => null,
                        'summary' => $locale === 'es' ? $membership['description_es'] : $membership['description_en'],
                        'body' => $locale === 'es' ? $membership['pador_text_es'] : $membership['pador_text_en'],
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
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
                ['alt_text' => 'Logo de membresía', 'caption' => null]
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

    private function authorizeMembershipAccess(Page $page): void
    {
        abort_unless($page->slug === 'membresias', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
