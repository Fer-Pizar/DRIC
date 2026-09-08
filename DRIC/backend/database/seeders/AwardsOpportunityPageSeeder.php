<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\AwardsOpportunityStaticContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AwardsOpportunityPageSeeder extends Seeder
{
    public function run(): void
    {
        $content = AwardsOpportunityStaticContent::all();
        $page = Page::updateOrCreate(
            ['slug' => 'premios-eventos-cursos-concursos'],
            [
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => 15,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
        $hero = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'awards_opportunities.hero'],
            ['section_type' => 'awards_opportunities_hero', 'sort_order' => 1, 'is_active' => true, 'settings' => ['editable' => true]]
        );
        $items = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => 'awards_opportunities.items'],
            ['section_type' => 'awards_opportunities_list', 'sort_order' => 2, 'is_active' => true, 'settings' => ['editable' => true]]
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
        }

        foreach ($content['opportunities'] as $index => $opportunity) {
            $block = ContentBlock::updateOrCreate(
                ['section_id' => $items->id, 'link_url' => 'awards-opportunity.'.Str::slug($opportunity['title']['es'] ?? (string) $index)],
                [
                    'block_type' => 'awards_opportunity',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'data' => [
                        'category' => $opportunity['category'] ?? ['es' => '', 'en' => ''],
                        'audience' => $opportunity['audience'] ?? ['es' => '', 'en' => ''],
                        'dates' => $opportunity['dates'] ?? null,
                        'deadline' => $opportunity['deadline'] ?? null,
                        'location' => $opportunity['location'] ?? null,
                        'format' => $opportunity['format'] ?? null,
                        'details' => $this->localizedItems($opportunity['details'] ?? []),
                        'benefits' => $this->localizedItems($opportunity['benefits'] ?? []),
                        'requirements' => $this->localizedItems($opportunity['requirements'] ?? []),
                        'documents' => $this->localizedItems($opportunity['documents'] ?? []),
                        'links' => $opportunity['links'] ?? [],
                        'contact' => $opportunity['contact'] ?? '',
                        'locked_design' => true,
                    ],
                ]
            );

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $opportunity['title'][$locale] ?? ($opportunity['title']['es'] ?? ''),
                        'subtitle' => $opportunity['category'][$locale] ?? ($opportunity['category']['es'] ?? ''),
                        'summary' => $opportunity['summary'][$locale] ?? ($opportunity['summary']['es'] ?? ''),
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
