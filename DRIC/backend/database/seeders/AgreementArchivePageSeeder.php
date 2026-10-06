<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AgreementArchivePageSeeder extends Seeder
{
    public function run(): void
    {
        $parent = Page::query()->where('slug', 'convenios')->firstOrFail();
        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pages() as $values) {
            $page = Page::updateOrCreate(
                ['slug' => $values['slug']],
                [
                    'parent_id' => $parent->id,
                    'page_type' => 'static',
                    'status' => 'published',
                    'published_at' => now(),
                    'sort_order' => $parent->sort_order,
                ]
            );

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $values["title_{$locale}"],
                        'menu_title' => $values["title_{$locale}"],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }

            $section = Section::firstOrNew(['page_id' => $page->id, 'section_key' => $values['section_key']]);
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
                        'title' => $values["section_title_{$locale}"],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }

            $this->seedDefaultDocuments($section, $values, $languages);
        }
    }

    private function pages(): array
    {
        return [
            [
                'slug' => 'convenios-otros',
                'section_key' => 'agreements.other.documents',
                'title_es' => 'Otros convenios suscritos',
                'title_en' => 'Other signed agreements',
                'section_title_es' => 'Documentos de otros convenios',
                'section_title_en' => 'Other agreement documents',
            ],
            [
                'slug' => 'convenios-ceub-gobierno',
                'section_key' => 'agreements.government.documents',
                'title_es' => 'Convenios CEUB y Gobierno de Bolivia',
                'title_en' => 'CEUB and Government of Bolivia Agreements',
                'section_title_es' => 'Documentos CEUB y Gobierno de Bolivia',
                'section_title_en' => 'CEUB and Government of Bolivia documents',
            ],
        ];
    }

    private function documentsFor(string $slug): array
    {
        $source = $this->frontendSource();

        return match ($slug) {
            'convenios-otros' => $this->parseOtherDocuments($source),
            'convenios-ceub-gobierno' => $this->parseGovernmentDocuments($source),
            default => [],
        };
    }

    private function frontendSource(): string
    {
        $path = base_path('../frontend/app/[locale]/(public)/convenios/[slug]/page.tsx');

        return is_file($path) ? (string) file_get_contents($path) : '';
    }

    private function parseOtherDocuments(string $source): array
    {
        if (! preg_match('/const otherAgreements(?:\s*:\s*[^=]+)?\s*=\s*(\[.*?\]);\s*const ceubSections/s', $source, $matches)) {
            return [];
        }

        preg_match_all(
            '/\{\s*es:\s*"((?:\\\\.|[^"\\\\])*)",\s*en:\s*"((?:\\\\.|[^"\\\\])*)",\s*href:\s*"([^"]+)"\s*,?\s*\}/s',
            $matches[1],
            $rows,
            PREG_SET_ORDER
        );

        return collect($rows)
            ->map(fn (array $row): array => [
                'es' => stripcslashes($row[1]),
                'en' => stripcslashes($row[2]),
                'href' => $row[3],
            ])
            ->all();
    }

    private function parseGovernmentDocuments(string $source): array
    {
        if (! preg_match('/const ceubSections(?:\s*:\s*[^=]+)?\s*=\s*(.*?);\s*const labels/s', $source, $matches)) {
            return [];
        }

        preg_match_all(
            '/\{\s*title:\s*"((?:\\\\.|[^"\\\\])*)",\s*agreements:\s*\[(.*?)\]\s*,?\s*\}/s',
            $matches[1],
            $sections,
            PREG_SET_ORDER
        );

        if ($sections !== []) {
            return collect($sections)
                ->flatMap(function (array $section): array {
                    preg_match_all(
                        '/\{\s*title:\s*"((?:\\\\.|[^"\\\\])*)",\s*href:\s*"([^"]+)"\s*,?\s*\}/s',
                        $section[2],
                        $rows,
                        PREG_SET_ORDER
                    );

                    return collect($rows)
                        ->map(fn (array $row): array => [
                            'es' => stripcslashes($row[1]),
                            'en' => stripcslashes($row[1]),
                            'href' => $row[2],
                            'country' => stripcslashes($section[1]),
                        ])
                        ->all();
                })
                ->all();
        }

        preg_match_all(
            '/\{\s*title:\s*"((?:\\\\.|[^"\\\\])*)",\s*href:\s*"([^"]+)"\s*,?\s*\}/s',
            $matches[1],
            $rows,
            PREG_SET_ORDER
        );

        return collect($rows)
            ->map(fn (array $row): array => [
                'es' => stripcslashes($row[1]),
                'en' => stripcslashes($row[1]),
                'href' => $row[2],
                'country' => null,
            ])
            ->all();
    }

    private function seedDefaultDocuments(Section $section, array $values, $languages): void
    {
        $documents = $this->documentsFor($values['slug']);
        $existingBlocks = ContentBlock::query()
            ->where('section_id', $section->id)
            ->orderBy('sort_order')
            ->get()
            ->values();
        $usedBlockIds = [];
        $nextSortOrder = ((int) ($existingBlocks->max('sort_order') ?? 0)) + 1;

        foreach ($documents as $index => $document) {
            $block = $this->matchingExistingBlock($existingBlocks, $document, $usedBlockIds);
            $isNewBlock = ! $block;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => $values['section_key'].'.'.Str::uuid()->toString(),
                ]);
            }

            $existingData = is_array($block->data) ? $block->data : [];
            $country = filled($existingData['country'] ?? null)
                ? $existingData['country']
                : ($document['country'] ?? null);

            $block->fill([
                'block_type' => 'agreement_document',
                'sort_order' => $isNewBlock ? $nextSortOrder++ : $block->sort_order,
                'is_active' => true,
                'data' => array_filter([
                    'href' => $existingData['href'] ?? $document['href'],
                    'country' => $country,
                ], fn ($value) => filled($value)),
            ]);
            $block->save();
            $usedBlockIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                $translation = ContentBlockTranslation::firstOrNew([
                    'content_block_id' => $block->id,
                    'language_id' => $languages[$locale]->id,
                ]);

                if (! filled($translation->title)) {
                    $translation->title = $document[$locale] ?? $document['es'];
                }

                $translation->subtitle ??= null;
                $translation->summary ??= null;
                $translation->body ??= null;
                $translation->save();
            }
        }

        $section->update([
            'settings' => array_merge($section->settings ?? [], ['editable' => true, 'seeded_default_documents' => true]),
        ]);
    }

    private function matchingExistingBlock($existingBlocks, array $document, array $usedBlockIds): ?ContentBlock
    {
        $availableBlocks = $existingBlocks->reject(fn (ContentBlock $block): bool => in_array($block->id, $usedBlockIds, true));

        $sameUrlBlocks = $availableBlocks->filter(
            fn (ContentBlock $block): bool => ($block->data['href'] ?? null) === $document['href']
        );

        if ($sameUrlBlocks->count() === 1) {
            return $sameUrlBlocks->first();
        }

        $sameTitleAndUrl = $sameUrlBlocks->first(function (ContentBlock $block) use ($document): bool {
            $spanishTitle = $block->translations->firstWhere('language.code', 'es')?->title ?? '';

            return $spanishTitle === $document['es'];
        });

        return $sameTitleAndUrl ?? null;
    }
}
