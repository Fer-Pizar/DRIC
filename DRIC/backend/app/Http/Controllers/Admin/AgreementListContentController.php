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

class AgreementListContentController extends Controller
{
    private const LISTS = [
        'otros' => [
            'page_slug' => 'convenios-otros',
            'section_key' => 'agreements.other.documents',
            'page_title_es' => 'Otros convenios suscritos',
            'page_title_en' => 'Other signed agreements',
            'section_title_es' => 'Documentos de otros convenios',
            'section_title_en' => 'Other agreement documents',
            'public_url' => '/es/convenios/otros',
        ],
        'ceub-gobierno' => [
            'page_slug' => 'convenios-ceub-gobierno',
            'section_key' => 'agreements.government.documents',
            'page_title_es' => 'Convenios CEUB y Gobierno de Bolivia',
            'page_title_en' => 'CEUB and Government of Bolivia Agreements',
            'section_title_es' => 'Documentos CEUB y Gobierno de Bolivia',
            'section_title_en' => 'CEUB and Government of Bolivia documents',
            'public_url' => '/es/convenios/ceub-gobierno',
        ],
    ];

    public function edit(string $list): View
    {
        $config = $this->config($list);
        $page = $this->ensurePage($config);
        $this->authorizeListAccess();

        $page->load([
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.agreement-list-content', [
            'list' => $list,
            'config' => $config,
            'agreementPage' => Page::query()->where('slug', 'convenios')->firstOrFail(),
            'documents' => $this->documents($page, $config),
        ]);
    }

    public function update(Request $request, string $list): RedirectResponse
    {
        $config = $this->config($list);
        $page = $this->ensurePage($config);
        $this->authorizeListAccess();

        $documents = $this->validatedDocuments($request);

        DB::transaction(function () use ($request, $page, $config, $documents): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $section = $this->ensureSection($page, $config, $languages);
            $keptIds = [];

            foreach ($documents as $sortOrder => $document) {
                $block = $document['id']
                    ? ContentBlock::query()
                        ->where('section_id', $section->id)
                        ->where('id', $document['id'])
                        ->first()
                    : null;

                if (! $block) {
                    $block = new ContentBlock([
                        'section_id' => $section->id,
                        'link_url' => $config['section_key'].'.'.Str::uuid()->toString(),
                    ]);
                }

                $block->fill([
                    'block_type' => 'agreement_document',
                    'sort_order' => $sortOrder + 1,
                    'is_active' => true,
                    'data' => ['href' => $document['url']],
                ]);
                $block->save();
                $keptIds[] = $block->id;

                foreach (['es', 'en'] as $locale) {
                    ContentBlockTranslation::updateOrCreate(
                        ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                        [
                            'title' => $locale === 'es' ? $document['title_es'] : $document['title_en'],
                            'subtitle' => null,
                            'summary' => null,
                            'body' => null,
                        ]
                    );
                }
            }

            ContentBlock::query()
                ->where('section_id', $section->id)
                ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
                ->delete();
        });

        return redirect()
            ->route('admin.agreement-lists.edit', $list)
            ->with('success', 'La lista de convenios fue actualizada correctamente.');
    }

    private function config(string $list): array
    {
        abort_unless(array_key_exists($list, self::LISTS), 404);

        return self::LISTS[$list];
    }

    private function ensurePage(array $config): Page
    {
        $parent = Page::query()->where('slug', 'convenios')->firstOrFail();
        $page = Page::updateOrCreate(
            ['slug' => $config['page_slug']],
            [
                'parent_id' => $parent->id,
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => $parent->sort_order,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach (['es', 'en'] as $locale) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $config["page_title_{$locale}"],
                    'menu_title' => $config["page_title_{$locale}"],
                    'subtitle' => null,
                    'summary' => null,
                    'body' => null,
                ]
            );
        }

        $this->ensureSection($page, $config, $languages);

        return $page;
    }

    private function ensureSection(Page $page, array $config, $languages): Section
    {
        $section = Section::firstOrNew(['page_id' => $page->id, 'section_key' => $config['section_key']]);
        $section->fill([
            'section_type' => 'agreement_document_list',
            'sort_order' => 1,
            'is_active' => true,
            'settings' => array_merge($section->settings ?? [], ['editable' => true]),
        ]);
        $section->save();

        foreach (['es', 'en'] as $locale) {
            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $config["section_title_{$locale}"],
                    'subtitle' => null,
                    'summary' => null,
                    'body' => null,
                ]
            );
        }

        return $section;
    }

    private function documents(Page $page, array $config): array
    {
        $section = $page->sections->firstWhere('section_key', $config['section_key']);
        $blocks = $section?->contentBlocks
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values() ?? collect();

        if ($blocks->isEmpty()) {
            return [];
        }

        return $blocks->map(fn (ContentBlock $block): array => [
            'id' => $block->id,
            'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
            'title_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
            'url' => is_string($block->data['href'] ?? null) ? $block->data['href'] : '',
        ])->all();
    }

    private function validatedDocuments(Request $request): array
    {
        $rows = collect($request->input('documents', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['url'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['documents' => $rows],
            [
                'documents' => ['array'],
                'documents.*.id' => ['nullable', 'integer'],
                'documents.*.title_es' => ['required', 'string', 'max:600'],
                'documents.*.title_en' => ['nullable', 'string', 'max:600'],
                'documents.*.url' => ['required', 'url', 'max:900'],
            ],
            [
                'documents.*.title_es.required' => 'Escribe el título del documento.',
                'documents.*.title_es.max' => 'El título es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.title_en.max' => 'El título en inglés es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.url.required' => 'Ingresa la URL del documento.',
                'documents.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf',
                'documents.*.url.max' => 'La URL es demasiado larga. Usa máximo 900 caracteres.',
            ]
        );

        $validated = $validator->validate();

        return collect($validated['documents'] ?? [])
            ->map(fn ($row): array => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'title_es' => trim($row['title_es']),
                'title_en' => trim($row['title_en'] ?? '') ?: trim($row['title_es']),
                'url' => trim($row['url']),
            ])
            ->all();
    }

    private function authorizeListAccess(): void
    {
        $agreementPage = Page::query()->where('slug', 'convenios')->firstOrFail();

        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $agreementPage), 403, 'No tienes permiso para editar Convenios.');
    }
}
