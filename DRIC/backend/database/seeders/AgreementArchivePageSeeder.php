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

            if (! ($section->settings['seeded_default_documents'] ?? false)) {
                $this->seedDefaultDocuments($section, $values, $languages);
            }
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
            '/\{\s*title:\s*"((?:\\\\.|[^"\\\\])*)",\s*href:\s*"([^"]+)"\s*\}/s',
            $matches[1],
            $rows,
            PREG_SET_ORDER
        );

        return collect($rows)
            ->map(fn (array $row): array => [
                'es' => stripcslashes($row[1]),
                'en' => stripcslashes($row[1]),
                'href' => $row[2],
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

        foreach ($documents as $index => $document) {
            $block = $existingBlocks[$index] ?? new ContentBlock([
                'section_id' => $section->id,
                'link_url' => $values['section_key'].'.'.Str::uuid()->toString(),
            ]);

            $block->fill([
                'block_type' => 'agreement_document',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => ['href' => $document['href']],
            ]);
            $block->save();

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $document[$locale] ?? $document['es'],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }
        }

        ContentBlock::query()
            ->where('section_id', $section->id)
            ->where('sort_order', '>', count($documents))
            ->update(['is_active' => false]);

        $section->update([
            'settings' => array_merge($section->settings ?? [], ['editable' => true, 'seeded_default_documents' => true]),
        ]);
    }
}
