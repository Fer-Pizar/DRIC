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

class AgreementContentController extends Controller
{
    private const MAX_IMAGE_KB = 5120;
    private const MAX_PDF_KB = 20480;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeAgreementAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.agreement-content', [
            'page' => $page,
            'content' => $this->formContent($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeAgreementAccess($page);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        $validated = $validator->validate();

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
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro_one']."\n\n".$validated[$locale]['intro_two'],
                        'body' => null,
                    ]
                );
            }

            $hero = $this->upsertSection($page, 'agreements.hero', 'agreements_hero', 1);
            $cards = $this->upsertSection($page, 'agreements.cards', 'agreements_cards', 2);

            foreach (['es', 'en'] as $locale) {
                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro_one'],
                        'body' => $validated[$locale]['intro_two'],
                    ]
                );
            }

            $heroImage = $this->upsertBlock($hero, 'agreements.hero-image', 'image', 1, $languages, [
                'es' => ['title' => 'Imagen principal de convenios', 'summary' => null],
                'en' => ['title' => 'Main agreements image', 'summary' => null],
            ]);

            $this->upsertBlock($cards, 'agreements.card-action', 'action_label', 0, $languages, [
                'es' => ['title' => $validated['es']['main_button'], 'summary' => null],
                'en' => ['title' => $validated['en']['main_button'], 'summary' => null],
            ]);

            $procedure = $this->upsertBlock($hero, 'agreements.procedure', 'procedure_link', 2, $languages, [
                'es' => ['title' => $validated['es']['procedure_label'], 'summary' => null],
                'en' => ['title' => $validated['en']['procedure_label'], 'summary' => null],
            ], [
                'url' => $validated['procedure_url'] ?? null,
            ]);

            foreach ([1, 2, 3] as $index) {
                $card = $this->upsertBlock($cards, "agreements.card.{$index}", 'agreement_card', $index, $languages, [
                    'es' => [
                        'title' => $validated['es']["card_{$index}_title"],
                        'summary' => $validated['es']["card_{$index}_description"],
                    ],
                    'en' => [
                        'title' => $validated['en']["card_{$index}_title"],
                        'summary' => $validated['en']["card_{$index}_description"],
                    ],
                ], [
                    'href' => $validated["card_{$index}_href"],
                ]);

                if ($request->hasFile("card_{$index}_image")) {
                    $card->update([
                        'media_asset_id' => $this->storeMedia($request, "card_{$index}_image", "agreements/card-{$index}", 'image')->id,
                    ]);
                }
            }

            if ($request->hasFile('hero_image')) {
                $heroImage->update([
                    'media_asset_id' => $this->storeMedia($request, 'hero_image', 'agreements/hero', 'image')->id,
                ]);
            }

            if ($request->hasFile('procedure_pdf')) {
                $procedure->update([
                    'media_asset_id' => $this->storeMedia($request, 'procedure_pdf', 'agreements/procedure', 'pdf')->id,
                    'data' => ['url' => null],
                ]);
            }
        });

        return redirect()
            ->route('admin.pages.agreements.edit', $page)
            ->with('success', 'El contenido de Convenios fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.eyebrow"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.intro_one"] = ['required', 'string', 'max:1000'];
            $localized["{$locale}.intro_two"] = ['required', 'string', 'max:1000'];
            $localized["{$locale}.main_button"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.procedure_label"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];

            foreach ([1, 2, 3] as $index) {
                $localized["{$locale}.card_{$index}_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
                $localized["{$locale}.card_{$index}_description"] = ['required', 'string', 'max:800'];
            }
        }

        return array_merge($localized, [
            'procedure_url' => ['nullable', 'url', 'max:500'],
            'card_1_href' => ['required', 'string', 'max:500'],
            'card_2_href' => ['required', 'string', 'max:500'],
            'card_3_href' => ['required', 'string', 'max:500'],
            'hero_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'card_1_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'card_2_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'card_3_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
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
            'hero_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'card_1_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'card_2_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'card_3_image.mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'procedure_pdf.mimes' => 'Ese formato no está permitido. Solo se aceptan archivos PDF.',
            'hero_image.max' => 'La imagen principal es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'card_1_image.max' => 'La imagen de la primera tarjeta es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'card_2_image.max' => 'La imagen de la segunda tarjeta es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'card_3_image.max' => 'La imagen de la tercera tarjeta es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'procedure_pdf.max' => 'El PDF es demasiado pesado. El tamaño máximo permitido es 20 MB.',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'agreements.hero', 'es', 'subtitle', 'Convenios institucionales'),
                'title' => $this->pageValue($page, 'es', 'title', 'Convenios suscritos por la UMSS'),
                'intro_one' => $this->sectionValue($page, 'agreements.hero', 'es', 'summary', 'La DRIC fortalece el vínculo de la UMSS con instituciones de educación superior e investigación, sectores público, privado y social, organismos internacionales, fundaciones y agencias de apoyo a la educación.'),
                'intro_two' => $this->sectionValue($page, 'agreements.hero', 'es', 'body', 'Los convenios suscritos favorecen el intercambio académico, la cooperación interinstitucional y el desarrollo de mecanismos de investigación con mayor impacto, eficiencia y resultados funcionales.'),
                'main_button' => $this->blockValue($page, 'agreements.card-action', 'es', 'title', 'Ver convenios'),
                'procedure_label' => $this->blockValue($page, 'agreements.procedure', 'es', 'title', 'Procedimiento para suscribir un convenio con la UMSS'),
                'card_1_title' => $this->blockValue($page, 'agreements.card.1', 'es', 'title', 'Convenios UMSS'),
                'card_1_description' => $this->blockValue($page, 'agreements.card.1', 'es', 'summary', 'Acuerdos institucionales supervisados por la DRIC para fortalecer la cooperación académica, científica y administrativa.'),
                'card_2_title' => $this->blockValue($page, 'agreements.card.2', 'es', 'title', 'Otros convenios suscritos'),
                'card_2_description' => $this->blockValue($page, 'agreements.card.2', 'es', 'summary', 'Convenios suscritos con instituciones que no han sido revisados directamente por la DRIC.'),
                'card_3_title' => $this->blockValue($page, 'agreements.card.3', 'es', 'title', 'Convenios CEUB y Gobierno de Bolivia'),
                'card_3_description' => $this->blockValue($page, 'agreements.card.3', 'es', 'summary', 'Acuerdos suscritos por el Gobierno de Bolivia y el Comité Ejecutivo de la Universidad Boliviana.'),
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'agreements.hero', 'en', 'subtitle', 'Institutional agreements'),
                'title' => $this->pageValue($page, 'en', 'title', 'Agreements signed by UMSS'),
                'intro_one' => $this->sectionValue($page, 'agreements.hero', 'en', 'summary', 'DRIC strengthens UMSS relationships with higher education and research institutions, public, private and social sectors, international organizations, foundations, and education support agencies.'),
                'intro_two' => $this->sectionValue($page, 'agreements.hero', 'en', 'body', 'Signed agreements promote academic exchange, interinstitutional cooperation, and research mechanisms with greater impact, efficiency, and functional results.'),
                'main_button' => $this->blockValue($page, 'agreements.card-action', 'en', 'title', 'View agreements'),
                'procedure_label' => $this->blockValue($page, 'agreements.procedure', 'en', 'title', 'Procedure to sign an agreement with UMSS'),
                'card_1_title' => $this->blockValue($page, 'agreements.card.1', 'en', 'title', 'UMSS Agreements'),
                'card_1_description' => $this->blockValue($page, 'agreements.card.1', 'en', 'summary', 'Institutional agreements supervised by DRIC to strengthen academic, scientific, and administrative cooperation.'),
                'card_2_title' => $this->blockValue($page, 'agreements.card.2', 'en', 'title', 'Other signed agreements'),
                'card_2_description' => $this->blockValue($page, 'agreements.card.2', 'en', 'summary', 'Agreements signed with institutions that have not been directly reviewed by DRIC.'),
                'card_3_title' => $this->blockValue($page, 'agreements.card.3', 'en', 'title', 'CEUB and Government of Bolivia Agreements'),
                'card_3_description' => $this->blockValue($page, 'agreements.card.3', 'en', 'summary', 'Agreements signed by the Government of Bolivia and the Executive Committee of the Bolivian University.'),
            ],
            'procedure_pdf_url' => $this->blockMediaUrl($page, 'agreements.procedure'),
            'procedure_url' => $this->procedureUrlValue($page),
            'card_1_href' => $this->blockData($page, 'agreements.card.1', 'href', 'https://conveniosdric.umss.edu.bo/convenios'),
            'card_2_href' => $this->blockData($page, 'agreements.card.2', 'href', '/convenios/otros'),
            'card_3_href' => $this->blockData($page, 'agreements.card.3', 'href', '/convenios/ceub-gobierno'),
            'hero_image_url' => $this->blockMediaUrl($page, 'agreements.hero-image'),
            'card_1_image_url' => $this->blockMediaUrl($page, 'agreements.card.1'),
            'card_2_image_url' => $this->blockMediaUrl($page, 'agreements.card.2'),
            'card_3_image_url' => $this->blockMediaUrl($page, 'agreements.card.3'),
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

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get();

        foreach ($languages as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                [
                    'alt_text' => $kind === 'pdf' ? 'Procedimiento para suscribir un convenio' : 'Imagen de convenios',
                    'caption' => null,
                ]
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
        $block = $this->block($page, $key);

        return $block?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockData(Page $page, string $key, string $dataKey, string $fallback): string
    {
        $value = $this->block($page, $key)?->data[$dataKey] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $fallback;
    }

    private function procedureUrlValue(Page $page): string
    {
        $procedure = $this->block($page, 'agreements.procedure');
        $value = $procedure?->data['url'] ?? null;

        if (is_string($value) && trim($value) !== '') {
            return $value;
        }

        return $procedure?->mediaAsset ? '' : 'https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf';
    }

    private function blockMediaUrl(Page $page, string $key): ?string
    {
        $media = $this->block($page, $key)?->mediaAsset;

        if (! $media?->file_path) {
            return null;
        }

        return '/storage/'.ltrim($media->file_path, '/');
    }

    private function block(Page $page, string $key): ?ContentBlock
    {
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key);
    }

    private function authorizeAgreementAccess(Page $page): void
    {
        abort_unless($page->slug === 'convenios', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
