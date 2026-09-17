<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\NationalForeignInfoStaticContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NationalForeignInfoPageSeeder extends Seeder
{
    public function run(): void
    {
        $content = NationalForeignInfoStaticContent::all();
        $hub = Page::query()->where('slug', 'becas-movilidad')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'informacion-nacionales-extranjeros'],
            [
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => 16,
                'parent_id' => $hub?->id,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
        $hero = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'national_foreign_info.hero'],
            ['section_type' => 'national_foreign_info_hero', 'sort_order' => 1, 'is_active' => true, 'settings' => ['editable' => true]]
        );
        $sections = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'national_foreign_info.sections'],
            ['section_type' => 'national_foreign_info_sections', 'sort_order' => 2, 'is_active' => true, 'settings' => ['editable' => true]]
        );

        foreach (['es', 'en'] as $locale) {
            $copy = $content['copy'][$locale] ?? [];

            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $copy['title'] ?? null,
                    'menu_title' => $copy['title'] ?? null,
                    'subtitle' => $copy['eyebrow'] ?? null,
                    'summary' => $copy['intro'] ?? null,
                    'body' => null,
                ]
            );

            SectionTranslation::updateOrCreate(
                ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $copy['title'] ?? null,
                    'subtitle' => $copy['eyebrow'] ?? null,
                    'summary' => $copy['intro'] ?? null,
                    'body' => null,
                ]
            );

            SectionTranslation::updateOrCreate(
                ['section_id' => $sections->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $copy['keyInfo'] ?? null,
                    'subtitle' => $copy['resources'] ?? null,
                    'summary' => $copy['photoSlot'] ?? null,
                    'body' => $copy['open'] ?? null,
                ]
            );
        }

        foreach ($content['sections'] as $index => $item) {
            $key = $item['id'] ?? Str::slug(data_get($item, 'title.es', 'tarjeta-'.$index));

            $block = ContentBlock::updateOrCreate(
                ['section_id' => $sections->id, 'link_url' => 'national-foreign-info.'.$key],
                [
                    'block_type' => 'national_foreign_info_section',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'data' => [
                        'id' => $key,
                        'eyebrow' => $item['eyebrow'] ?? ['es' => '', 'en' => ''],
                        'image' => $item['image'] ?? '',
                        'image_alt' => $item['imageAlt'] ?? ['es' => '', 'en' => ''],
                        'points' => $this->localizedItems($item['points'] ?? []),
                        'links' => $item['links'] ?? [],
                        'locked_design' => true,
                    ],
                ]
            );

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => data_get($item, "title.{$locale}", data_get($item, 'title.es', '')),
                        'subtitle' => data_get($item, "eyebrow.{$locale}", data_get($item, 'eyebrow.es', '')),
                        'summary' => data_get($item, "summary.{$locale}", data_get($item, 'summary.es', '')),
                        'body' => null,
                    ]
                );
            }
        }
    }

    private function localizedItems(array $items): array
    {
        return [
            'es' => collect($items)->map(fn ($item) => $item['es'] ?? null)->filter()->values()->all(),
            'en' => collect($items)->map(fn ($item) => $item['en'] ?? ($item['es'] ?? null))->filter()->values()->all(),
        ];
    }
}
