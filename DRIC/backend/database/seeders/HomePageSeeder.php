<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Section;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'inicio')->first();

        if (!$page) {
            return;
        }

        $sections = [
            ['type' => 'hero', 'order' => 1],
            ['type' => 'scholarship_country_grid', 'order' => 2],
            ['type' => 'about_dric', 'order' => 3],
            ['type' => 'recent_agreements', 'order' => 4],
            ['type' => 'director', 'order' => 5],
            ['type' => 'stats', 'order' => 6],
            ['type' => 'faq', 'order' => 7],
            ['type' => 'final_cta', 'order' => 8],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'section_type' => $section['type'],
                ],
                [
                    'sort_order' => $section['order'],
                    'is_active' => true,
                    'settings' => json_encode([
                        'animation' => 'fade-up',
                        'theme' => 'dark'
                    ]),
                ]
            );
        }
    }
}