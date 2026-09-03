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

class ProjectPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'proyectos')->firstOrFail();

        $page->update([
            'status' => 'published',
            'published_at' => $page->published_at ?? now(),
        ]);

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }

        $hero = $this->upsertSection($page, 'projects.hero', 'projects_hero', 1, $languages, [
            'es' => [
                'title' => 'Proyectos',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'Gestionamos, asesoramos y facilitamos solicitudes de proyectos con financiamiento nacional e internacional, fortaleciendo la cooperación académica, científica e institucional de la Universidad Mayor de San Simón.',
                'body' => null,
            ],
            'en' => [
                'title' => 'Projects',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'We manage, advise on, and support project requests with national and international funding, strengthening the academic, scientific, and institutional cooperation of Universidad Mayor de San Simón.',
                'body' => null,
            ],
        ]);

        $cards = $this->upsertSection($page, 'projects.cards', 'projects_cards', 2, $languages, [
            'es' => ['title' => 'Accesos de proyectos', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Project links', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $this->upsertBlock($hero, 'projects.procedure', 'procedure_link', 1, $languages, [
            'es' => ['title' => 'Procedimiento UMSS', 'summary' => null],
            'en' => ['title' => 'UMSS Procedure', 'summary' => null],
        ], [
            'url' => 'https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf',
        ]);

        foreach ($this->cards() as $index => $card) {
            $this->upsertBlock($cards, 'projects.card.'.($index + 1), 'project_card', $index + 1, $languages, [
                'es' => [
                    'title' => $card['title_es'],
                    'summary' => $card['description_es'],
                    'cta_label' => $card['button_es'],
                ],
                'en' => [
                    'title' => $card['title_en'],
                    'summary' => $card['description_en'],
                    'cta_label' => $card['button_en'],
                ],
            ], [
                'href' => $card['href'],
                'icon' => $card['icon'],
            ]);
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => [
                'title' => 'Proyectos',
                'menu_title' => 'Proyectos',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'Gestionamos, asesoramos y facilitamos solicitudes de proyectos con financiamiento nacional e internacional, fortaleciendo la cooperación académica, científica e institucional de la Universidad Mayor de San Simón.',
                'body' => null,
            ],
            'en' => [
                'title' => 'Projects',
                'menu_title' => 'Projects',
                'subtitle' => 'DRIC · UMSS',
                'summary' => 'We manage, advise on, and support project requests with national and international funding, strengthening the academic, scientific, and institutional cooperation of Universidad Mayor de San Simón.',
                'body' => null,
            ],
        ];
    }

    private function cards(): array
    {
        return [
            [
                'title_es' => 'Proyectos Internacionales',
                'title_en' => 'International Projects',
                'description_es' => 'Proyectos desarrollados con cooperación internacional en la UMSS, orientados a investigación, innovación, fortalecimiento institucional y vinculación global.',
                'description_en' => 'Projects developed through international cooperation at UMSS, focused on research, innovation, institutional strengthening, and global engagement.',
                'href' => 'https://conveniosdric.umss.edu.bo/proyectos',
                'icon' => 'world',
                'button_es' => 'Ver proyectos',
                'button_en' => 'View projects',
            ],
            [
                'title_es' => 'Apoyo Financiero',
                'title_en' => 'Financial Support',
                'description_es' => 'Información sobre convocatorias, oportunidades de financiamiento y recursos para fortalecer iniciativas académicas e institucionales.',
                'description_en' => 'Information about calls for proposals, funding opportunities, and resources to strengthen academic and institutional initiatives.',
                'href' => 'apoyo-financiero',
                'icon' => 'finance',
                'button_es' => 'Ver convocatorias',
                'button_en' => 'View calls',
            ],
        ];
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder, $languages, array $translations): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            [
                'section_type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'settings' => ['editable' => true],
            ]
        );

        foreach ($translations as $locale => $values) {
            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }

        return $section;
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): void
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
    }
}
