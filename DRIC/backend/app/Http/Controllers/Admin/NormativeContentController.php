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

class NormativeContentController extends Controller
{
    private const MAX_PDF_KB = 20480;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    private const CATEGORIES = [
        'primero' => ['es' => 'Primero', 'en' => 'First'],
        'segundo' => ['es' => 'Segundo', 'en' => 'Second'],
        'tercero' => ['es' => 'Tercero', 'en' => 'Third'],
    ];

    public function edit(Page $page): View
    {
        $this->authorizeNormativeAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset',
        ]);

        return view('admin.pages.normative-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'documents' => $this->documents($page),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeNormativeAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $documents = $this->validatedDocuments($request);

        DB::transaction(function () use ($request, $validated, $documents, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'regulations.hero', 'regulations_hero', 1);
            $list = $this->upsertSection($page, 'regulations.list', 'regulations_list', 2);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
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
                        'title' => 'Documentos normativos',
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }

            $this->syncDocuments($request, $list, $documents, $languages);
        });

        return redirect()
            ->route('admin.pages.normatives.edit', $page)
            ->with('success', 'El contenido de Normativas fue actualizado correctamente.');
    }

    private function rules(): array
    {
        return [
            'es.eyebrow' => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
            'en.eyebrow' => ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX],
            'es.title' => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX],
            'en.title' => ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX],
            'es.intro' => ['required', 'string', 'max:900'],
            'en.intro' => ['required', 'string', 'max:900'],
        ];
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function validatedDocuments(Request $request): array
    {
        $rows = collect($request->input('documents', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['url'] ?? null) || filled($row['code'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $files = $request->file('documents', []);

        $validator = Validator::make(
            ['documents' => $rows],
            [
                'documents' => ['array'],
                'documents.*.id' => ['nullable', 'integer'],
                'documents.*.is_active' => ['nullable', 'boolean'],
                'documents.*.code' => ['nullable', 'string', 'max:80'],
                'documents.*.category' => ['required', 'in:primero,segundo,tercero'],
                'documents.*.title_es' => ['required', 'string', 'max:700'],
                'documents.*.title_en' => ['nullable', 'string', 'max:700'],
                'documents.*.url' => ['nullable', 'url', 'max:1000'],
            ],
            [
                'documents.*.category.required' => 'Selecciona una categoría.',
                'documents.*.category.in' => 'Selecciona una categoría válida.',
                'documents.*.title_es.required' => 'Escribe el título del documento.',
                'documents.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf',
                'documents.*.url.max' => 'La URL es demasiado larga.',
            ]
        );

        $validator->after(function ($validator) use ($rows, $files): void {
            foreach ($rows as $index => $row) {
                $hasStoredDocument = filled($row['id'] ?? null) && filled($row['existing_url'] ?? null);
                $hasUrl = filled($row['url'] ?? null);
                $hasFile = isset($files[$index]['pdf']) && $files[$index]['pdf']?->isValid();

                if (! $hasStoredDocument && ! $hasUrl && ! $hasFile) {
                    $validator->errors()->add("documents.{$index}.url", 'Agrega una URL o sube un PDF para este documento.');
                }

                if (! $hasFile) {
                    continue;
                }

                $file = $files[$index]['pdf'];
                if ($file->getClientOriginalExtension() !== 'pdf' && $file->getMimeType() !== 'application/pdf') {
                    $validator->errors()->add("documents.{$index}.pdf", 'Ese formato no está permitido. Sube un PDF.');
                }

                if ($file->getSize() > self::MAX_PDF_KB * 1024) {
                    $validator->errors()->add("documents.{$index}.pdf", 'El PDF sobrepasa los 20MB.');
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['documents'] ?? [])
            ->map(fn ($row, $index) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'is_active' => (bool) ($row['is_active'] ?? false),
                'code' => trim($row['code'] ?? ''),
                'category' => $row['category'],
                'title_es' => trim($row['title_es']),
                'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                'url' => trim($row['url'] ?? ''),
                'file' => $files[$index]['pdf'] ?? null,
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'regulations.hero', 'es', 'subtitle', 'Marco institucional'),
                'title' => $this->pageValue($page, 'es', 'title', 'Normativas'),
                'intro' => $this->sectionValue($page, 'regulations.hero', 'es', 'summary', 'Reglamentos, resoluciones, políticas y documentos oficiales vinculados a internacionalización, movilidad académica, cooperación y convenios de la UMSS.'),
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'regulations.hero', 'en', 'subtitle', 'Institutional framework'),
                'title' => $this->pageValue($page, 'en', 'title', 'Regulations'),
                'intro' => $this->sectionValue($page, 'regulations.hero', 'en', 'summary', 'Official regulations, resolutions, policies, and institutional documents related to UMSS internationalization, academic mobility, cooperation, and agreements.'),
            ],
        ];
    }

    private function documents(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'regulations.list');

        return ($section?->contentBlocks ?? collect())
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'is_active' => (bool) $block->is_active,
                'code' => is_string($block->data['code'] ?? null) ? $block->data['code'] : '',
                'category' => is_string($block->data['category'] ?? null) ? $block->data['category'] : 'primero',
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'url' => is_string($block->data['download_url'] ?? null) ? $block->data['download_url'] : '',
                'file_name' => $block->mediaAsset?->file_name,
            ])
            ->all();
    }

    private function syncDocuments(Request $request, Section $section, array $documents, $languages): void
    {
        $keptIds = [];

        foreach ($documents as $index => $document) {
            $block = $document['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $document['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'regulations.document.'.Str::uuid()->toString(),
                ]);
            }

            $media = $block->mediaAsset;
            $downloadUrl = $document['url'] ?: ($block->data['download_url'] ?? '');

            if ($document['file'] && $document['file']->isValid()) {
                if ($media) {
                    Storage::disk($media->disk ?? 'public')->delete($media->file_path);
                    $media->delete();
                }

                $media = $this->storePdfFile($document['file'], $request->user()->id);
                $downloadUrl = '/storage/'.ltrim($media->file_path, '/');
            }

            $categoryLabels = self::CATEGORIES[$document['category']];

            $block->fill([
                'block_type' => 'regulation_document',
                'sort_order' => $index + 1,
                'is_active' => $document['is_active'],
                'media_asset_id' => $media?->id,
                'data' => [
                    'code' => $document['code'],
                    'category' => $document['category'],
                    'category_label_es' => $categoryLabels['es'],
                    'category_label_en' => $categoryLabels['en'],
                    'category_url' => 'https://dric.umss.edu.bo/document-category/'.$document['category'].'/',
                    'download_url' => $downloadUrl,
                ],
            ]);

            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $document['title_es'] : $document['title_en'],
                        'subtitle' => $categoryLabels[$locale],
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
            ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
            ->get()
            ->each(function (ContentBlock $block): void {
                if ($block->mediaAsset) {
                    Storage::disk($block->mediaAsset->disk ?? 'public')->delete($block->mediaAsset->file_path);
                    $block->mediaAsset->delete();
                }

                $block->delete();
            });
    }

    private function storePdfFile($file, ?int $userId): MediaAsset
    {
        $path = $file->store('normativas', 'public');
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

    private function authorizeNormativeAccess(Page $page): void
    {
        abort_unless($page->slug === 'normativas', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
