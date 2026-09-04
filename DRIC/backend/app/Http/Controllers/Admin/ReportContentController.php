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

class ReportContentController extends Controller
{
    private const MAX_PDF_KB = 20480;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeReportAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset',
        ]);

        return view('admin.pages.report-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'reports' => $this->reports($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeReportAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $reports = $this->validatedReports($request);

        DB::transaction(function () use ($request, $validated, $reports, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'reports.hero', 'reports_hero', 1);
            $archive = $this->upsertSection($page, 'reports.archive', 'reports_archive', 2);

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
                        'body' => $validated[$locale]['archive_description'],
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $archive->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['archive_title'],
                        'subtitle' => $validated[$locale]['explore_label'],
                        'summary' => $validated[$locale]['search_placeholder'],
                        'body' => null,
                    ]
                );
            }

            $settings = $archive->settings ?? [];
            $settings['archive_label_es'] = $validated['es']['archive_label'];
            $settings['archive_label_en'] = $validated['en']['archive_label'];
            $settings['cover_eyebrow_es'] = $validated['es']['cover_eyebrow'];
            $settings['cover_eyebrow_en'] = $validated['en']['cover_eyebrow'];
            $settings['cover_title_es'] = $validated['es']['cover_title'];
            $settings['cover_title_en'] = $validated['en']['cover_title'];
            $settings['year_label_es'] = $validated['es']['year_label'];
            $settings['year_label_en'] = $validated['en']['year_label'];
            $settings['download_label_es'] = $validated['es']['download_label'];
            $settings['download_label_en'] = $validated['en']['download_label'];
            $archive->update(['settings' => $settings]);

            $this->syncReports($request, $archive, $reports, $languages);
        });

        return redirect()
            ->route('admin.pages.reports.edit', $page)
            ->with('success', 'El contenido de Informes de Gestión fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.eyebrow"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:900'];
            $rules["{$locale}.archive_label"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.archive_description"] = ['required', 'string', 'max:500'];
            $rules["{$locale}.explore_label"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.archive_title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.search_placeholder"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.cover_eyebrow"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.cover_title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.year_label"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.download_label"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
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
        ];
    }

    private function validatedReports(Request $request): array
    {
        $rows = collect($request->input('reports', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['year'] ?? null) || filled($row['date_es'] ?? null) || filled($row['url'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $files = $request->file('reports', []);

        $validator = Validator::make(
            ['reports' => $rows],
            [
                'reports' => ['array'],
                'reports.*.id' => ['nullable', 'integer'],
                'reports.*.is_active' => ['nullable', 'boolean'],
                'reports.*.year' => ['required', 'integer', 'min:1900', 'max:2100'],
                'reports.*.date_es' => ['required', 'string', 'max:80'],
                'reports.*.date_en' => ['nullable', 'string', 'max:80'],
                'reports.*.title_es' => ['required', 'string', 'max:220'],
                'reports.*.title_en' => ['nullable', 'string', 'max:220'],
                'reports.*.url' => ['nullable', 'string', 'max:1000'],
            ],
            [
                'reports.*.year.required' => 'Escribe la gestión del informe.',
                'reports.*.year.integer' => 'La gestión debe ser un año válido, por ejemplo 2024.',
                'reports.*.date_es.required' => 'Escribe la fecha visible del informe.',
                'reports.*.title_es.required' => 'Escribe el título del informe.',
                'reports.*.url.max' => 'La URL es demasiado larga.',
            ]
        );

        $validator->after(function ($validator) use ($rows, $files): void {
            foreach ($rows as $index => $row) {
                $url = trim($row['url'] ?? '');
                $hasStoredDocument = filled($row['id'] ?? null) && filled($row['existing_url'] ?? null);
                $hasUrl = $url !== '';
                $hasFile = isset($files[$index]['pdf']) && $files[$index]['pdf']?->isValid();

                if ($hasUrl && $url !== '#' && ! filter_var($url, FILTER_VALIDATE_URL) && ! Str::startsWith($url, ['/'])) {
                    $validator->errors()->add("reports.{$index}.url", 'Ingresa una URL completa o una ruta interna que empiece con /.');
                }

                if (! $hasStoredDocument && ! $hasUrl && ! $hasFile) {
                    $validator->errors()->add("reports.{$index}.url", 'Agrega una URL o sube un PDF para este informe.');
                }

                if (! $hasFile) {
                    continue;
                }

                $file = $files[$index]['pdf'];
                if ($file->getClientOriginalExtension() !== 'pdf' && $file->getMimeType() !== 'application/pdf') {
                    $validator->errors()->add("reports.{$index}.pdf", 'Ese formato no está permitido. Sube un PDF.');
                }

                if ($file->getSize() > self::MAX_PDF_KB * 1024) {
                    $validator->errors()->add("reports.{$index}.pdf", 'El PDF sobrepasa los 20MB.');
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['reports'] ?? [])
            ->map(fn ($row, $index) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'is_active' => (bool) ($row['is_active'] ?? false),
                'year' => (string) $row['year'],
                'date_es' => trim($row['date_es']),
                'date_en' => trim($row['date_en'] ?? '') ?: trim($row['date_es']),
                'title_es' => trim($row['title_es']),
                'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                'url' => trim($row['url'] ?? ''),
                'file' => $files[$index]['pdf'] ?? null,
            ])
            ->sortByDesc(fn (array $report) => $report['year'])
            ->values()
            ->all();
    }

    private function formContent(Page $page): array
    {
        $archive = $page->sections->firstWhere('section_key', 'reports.archive');
        $settings = $archive?->settings ?? [];

        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'reports.hero', 'es', 'subtitle', 'Transparencia institucional'),
                'title' => $this->pageValue($page, 'es', 'title', 'Informes de Gestión'),
                'intro' => $this->sectionValue($page, 'reports.hero', 'es', 'summary', 'Consulta los informes institucionales de la Dirección de Relaciones Internacionales y Convenios, organizados por gestión para fortalecer la transparencia y el acceso público a la información.'),
                'archive_label' => is_string($settings['archive_label_es'] ?? null) ? $settings['archive_label_es'] : 'Archivo DRIC',
                'archive_description' => $this->sectionValue($page, 'reports.hero', 'es', 'body', 'Una colección histórica de gestiones institucionales preparada para consulta pública y descarga documental.'),
                'explore_label' => $this->sectionValue($page, 'reports.archive', 'es', 'subtitle', 'Explorar documentos'),
                'archive_title' => $this->sectionValue($page, 'reports.archive', 'es', 'title', 'Archivo de informes'),
                'search_placeholder' => $this->sectionValue($page, 'reports.archive', 'es', 'summary', 'Buscar informe...'),
                'cover_eyebrow' => is_string($settings['cover_eyebrow_es'] ?? null) ? $settings['cover_eyebrow_es'] : 'Dirección de',
                'cover_title' => is_string($settings['cover_title_es'] ?? null) ? $settings['cover_title_es'] : 'Relaciones Internacionales y Convenios',
                'year_label' => is_string($settings['year_label_es'] ?? null) ? $settings['year_label_es'] : 'Gestión',
                'download_label' => is_string($settings['download_label_es'] ?? null) ? $settings['download_label_es'] : 'Descargar PDF',
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'reports.hero', 'en', 'subtitle', 'Institutional transparency'),
                'title' => $this->pageValue($page, 'en', 'title', 'Management Reports'),
                'intro' => $this->sectionValue($page, 'reports.hero', 'en', 'summary', 'Review the institutional reports of the Directorate of International Relations and Agreements, organized by year to strengthen transparency and public access to information.'),
                'archive_label' => is_string($settings['archive_label_en'] ?? null) ? $settings['archive_label_en'] : 'DRIC Archive',
                'archive_description' => $this->sectionValue($page, 'reports.hero', 'en', 'body', 'A historical collection of institutional terms prepared for public consultation and document downloads.'),
                'explore_label' => $this->sectionValue($page, 'reports.archive', 'en', 'subtitle', 'Explore documents'),
                'archive_title' => $this->sectionValue($page, 'reports.archive', 'en', 'title', 'Reports archive'),
                'search_placeholder' => $this->sectionValue($page, 'reports.archive', 'en', 'summary', 'Search report...'),
                'cover_eyebrow' => is_string($settings['cover_eyebrow_en'] ?? null) ? $settings['cover_eyebrow_en'] : 'Directorate of',
                'cover_title' => is_string($settings['cover_title_en'] ?? null) ? $settings['cover_title_en'] : 'International Relations and Agreements',
                'year_label' => is_string($settings['year_label_en'] ?? null) ? $settings['year_label_en'] : 'Year',
                'download_label' => is_string($settings['download_label_en'] ?? null) ? $settings['download_label_en'] : 'Download PDF',
            ],
        ];
    }

    private function reports(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'reports.archive');

        return ($section?->contentBlocks ?? collect())
            ->sortByDesc(fn (ContentBlock $block) => (int) ($block->data['year'] ?? 0))
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'is_active' => (bool) $block->is_active,
                'year' => is_string($block->data['year'] ?? null) ? $block->data['year'] : '',
                'date_es' => $block->translations->firstWhere('language.code', 'es')?->cta_label ?? '',
                'date_en' => $block->translations->firstWhere('language.code', 'en')?->cta_label ?? '',
                'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'url' => is_string($block->data['download_url'] ?? null) ? $block->data['download_url'] : '',
                'file_name' => $block->mediaAsset?->file_name,
            ])
            ->all();
    }

    private function syncReports(Request $request, Section $section, array $reports, $languages): void
    {
        $keptIds = [];

        foreach ($reports as $index => $report) {
            $block = $report['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $report['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'reports.item.'.Str::uuid()->toString(),
                ]);
            }

            $media = $block->mediaAsset;
            $downloadUrl = $report['url'] ?: ($block->data['download_url'] ?? '');

            if ($report['file'] && $report['file']->isValid()) {
                if ($media) {
                    Storage::disk($media->disk ?? 'public')->delete($media->file_path);
                    $media->delete();
                }

                $media = $this->storePdfFile($report['file'], $request->user()->id);
                $downloadUrl = '/storage/'.ltrim($media->file_path, '/');
            }

            $block->fill([
                'block_type' => 'management_report',
                'sort_order' => $index + 1,
                'is_active' => $report['is_active'],
                'media_asset_id' => $media?->id,
                'data' => [
                    'year' => $report['year'],
                    'download_url' => $downloadUrl,
                ],
            ]);

            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $report['title_es'] : $report['title_en'],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                        'cta_label' => $locale === 'es' ? $report['date_es'] : $report['date_en'],
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
        $path = $file->store('informes-gestion', 'public');
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

    private function authorizeReportAccess(Page $page): void
    {
        abort_unless($page->slug === 'informes-gestion', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
