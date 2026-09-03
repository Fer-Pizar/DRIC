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
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProjectContentController extends Controller
{
    private const MAX_IMAGE_KB = 5120;
    private const MAX_PDF_KB = 20480;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeProjectAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.project-content', [
            'page' => $page,
            'content' => $this->formContent($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeProjectAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();

        DB::transaction(function () use ($request, $validated, $page): void {
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
                        'subtitle' => 'DRIC · UMSS',
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );
            }

            $hero = $this->upsertSection($page, 'projects.hero', 'projects_hero', 1);
            $cards = $this->upsertSection($page, 'projects.cards', 'projects_cards', 2);

            foreach (['es', 'en'] as $locale) {
                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => 'DRIC · UMSS',
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );
            }

            $procedure = $this->upsertBlock($hero, 'projects.procedure', 'procedure_link', 1, $languages, [
                'es' => ['title' => $validated['es']['procedure_label'], 'summary' => null],
                'en' => ['title' => $validated['en']['procedure_label'], 'summary' => null],
            ], ['url' => $validated['procedure_url'] ?? null]);

            foreach ([1, 2] as $index) {
                $card = $this->upsertBlock($cards, "projects.card.{$index}", 'project_card', $index, $languages, [
                    'es' => [
                        'title' => $validated['es']["card_{$index}_title"],
                        'summary' => $validated['es']["card_{$index}_description"],
                        'cta_label' => $validated['es']["card_{$index}_button"],
                    ],
                    'en' => [
                        'title' => $validated['en']["card_{$index}_title"],
                        'summary' => $validated['en']["card_{$index}_description"],
                        'cta_label' => $validated['en']["card_{$index}_button"],
                    ],
                ], [
                    'href' => $validated["card_{$index}_href"],
                    'icon' => $index === 1 ? 'world' : 'finance',
                ]);

                if ($request->hasFile("card_{$index}_image")) {
                    $card->update([
                        'media_asset_id' => $this->storeMedia($request, "card_{$index}_image", "projects/card-{$index}", 'image')->id,
                    ]);
                }
            }

            if ($request->hasFile('procedure_pdf')) {
                $procedure->update([
                    'media_asset_id' => $this->storeMedia($request, 'procedure_pdf', 'projects/procedure', 'pdf')->id,
                    'data' => ['url' => null],
                ]);
            }
        });

        return redirect()
            ->route('admin.pages.projects.edit', $page)
            ->with('success', 'El contenido de Proyectos fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.intro"] = ['required', 'string', 'max:1200'];
            $localized["{$locale}.procedure_label"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];

            foreach ([1, 2] as $index) {
                $localized["{$locale}.card_{$index}_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
                $localized["{$locale}.card_{$index}_description"] = ['required', 'string', 'max:800'];
                $localized["{$locale}.card_{$index}_button"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            }
        }

        return array_merge($localized, [
            'procedure_url' => ['nullable', 'url', 'max:500'],
            'card_1_href' => ['required', 'string', 'max:500'],
            'card_2_href' => ['required', 'string', 'max:500'],
            'card_1_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'card_2_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'procedure_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:'.self::MAX_PDF_KB],
        ]);
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/archivo.pdf',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'file' => 'Debes subir un archivo válido.',
            'mimes' => 'Ese formato no está permitido.',
            'card_1_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'card_2_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'procedure_pdf.mimes' => 'Ese formato no está permitido. Solo se aceptan archivos PDF.',
            'card_1_image.max' => 'La imagen de la primera tarjeta es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'card_2_image.max' => 'La imagen de la segunda tarjeta es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'procedure_pdf.max' => 'El PDF es demasiado pesado. El tamaño máximo permitido es 20 MB.',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'title' => $this->pageValue($page, 'es', 'title', 'Proyectos'),
                'intro' => $this->sectionValue($page, 'projects.hero', 'es', 'summary', 'Gestionamos, asesoramos y facilitamos solicitudes de proyectos con financiamiento nacional e internacional, fortaleciendo la cooperación académica, científica e institucional de la Universidad Mayor de San Simón.'),
                'procedure_label' => $this->blockValue($page, 'projects.procedure', 'es', 'title', 'Procedimiento UMSS'),
                'card_1_title' => $this->blockValue($page, 'projects.card.1', 'es', 'title', 'Proyectos Internacionales'),
                'card_1_description' => $this->blockValue($page, 'projects.card.1', 'es', 'summary', 'Proyectos desarrollados con cooperación internacional en la UMSS, orientados a investigación, innovación, fortalecimiento institucional y vinculación global.'),
                'card_1_button' => $this->blockValue($page, 'projects.card.1', 'es', 'cta_label', 'Ver proyectos'),
                'card_2_title' => $this->blockValue($page, 'projects.card.2', 'es', 'title', 'Apoyo Financiero'),
                'card_2_description' => $this->blockValue($page, 'projects.card.2', 'es', 'summary', 'Información sobre convocatorias, oportunidades de financiamiento y recursos para fortalecer iniciativas académicas e institucionales.'),
                'card_2_button' => $this->blockValue($page, 'projects.card.2', 'es', 'cta_label', 'Ver convocatorias'),
            ],
            'en' => [
                'title' => $this->pageValue($page, 'en', 'title', 'Projects'),
                'intro' => $this->sectionValue($page, 'projects.hero', 'en', 'summary', 'We manage, advise on, and support project requests with national and international funding, strengthening the academic, scientific, and institutional cooperation of Universidad Mayor de San Simón.'),
                'procedure_label' => $this->blockValue($page, 'projects.procedure', 'en', 'title', 'UMSS Procedure'),
                'card_1_title' => $this->blockValue($page, 'projects.card.1', 'en', 'title', 'International Projects'),
                'card_1_description' => $this->blockValue($page, 'projects.card.1', 'en', 'summary', 'Projects developed through international cooperation at UMSS, focused on research, innovation, institutional strengthening, and global engagement.'),
                'card_1_button' => $this->blockValue($page, 'projects.card.1', 'en', 'cta_label', 'View projects'),
                'card_2_title' => $this->blockValue($page, 'projects.card.2', 'en', 'title', 'Financial Support'),
                'card_2_description' => $this->blockValue($page, 'projects.card.2', 'en', 'summary', 'Information about calls for proposals, funding opportunities, and resources to strengthen academic and institutional initiatives.'),
                'card_2_button' => $this->blockValue($page, 'projects.card.2', 'en', 'cta_label', 'View calls'),
            ],
            'procedure_pdf_url' => $this->blockMediaUrl($page, 'projects.procedure'),
            'procedure_url' => $this->procedureUrlValue($page),
            'card_1_href' => $this->blockData($page, 'projects.card.1', 'href', 'https://conveniosdric.umss.edu.bo/proyectos'),
            'card_2_href' => $this->blockData($page, 'projects.card.2', 'href', 'apoyo-financiero'),
            'card_1_image_url' => $this->blockMediaUrl($page, 'projects.card.1'),
            'card_2_image_url' => $this->blockMediaUrl($page, 'projects.card.2'),
        ];
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            [
                'section_type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'settings' => ['editable' => true],
            ]
        );
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): ContentBlock
    {
        $block = ContentBlock::updateOrCreate(
            ['section_id' => $section->id, 'link_url' => $key],
            [
                'block_type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'data' => $data,
            ]
        );

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'],
                    'subtitle' => null,
                    'summary' => $translations[$locale]['summary'],
                    'body' => null,
                    'cta_label' => $translations[$locale]['cta_label'] ?? null,
                ]
            );
        }

        return $block;
    }

    private function storeMedia(Request $request, string $field, string $prefix, string $kind): MediaAsset
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
                ['alt_text' => $kind === 'pdf' ? 'Procedimiento UMSS' : 'Imagen de proyectos', 'caption' => null]
            );
        }

        return $media;
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        $section = $page->sections->firstWhere('section_key', $key);

        return $section?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
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

    private function procedureUrlValue(Page $page): string
    {
        $procedure = $this->block($page, 'projects.procedure');
        $value = $procedure?->data['url'] ?? null;

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        return $procedure?->mediaAsset ? '' : 'https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf';
    }

    private function blockMediaUrl(Page $page, string $key): ?string
    {
        $media = $this->block($page, $key)?->mediaAsset;

        return $media?->file_path ? '/storage/'.ltrim($media->file_path, '/') : null;
    }

    private function block(Page $page, string $key): ?ContentBlock
    {
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key);
    }

    private function authorizeProjectAccess(Page $page): void
    {
        abort_unless($page->slug === 'proyectos', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
