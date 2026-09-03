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

class AgreementPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'convenios')->firstOrFail();

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

        $hero = $this->upsertSection($page, 'agreements.hero', 'agreements_hero', 1, $languages, [
            'es' => [
                'title' => 'Convenios suscritos por la UMSS',
                'subtitle' => 'Convenios institucionales',
                'summary' => 'La DRIC fortalece el vínculo de la UMSS con instituciones de educación superior e investigación, sectores público, privado y social, organismos internacionales, fundaciones y agencias de apoyo a la educación.',
                'body' => 'Los convenios suscritos favorecen el intercambio académico, la cooperación interinstitucional y el desarrollo de mecanismos de investigación con mayor impacto, eficiencia y resultados funcionales.',
            ],
            'en' => [
                'title' => 'Agreements signed by UMSS',
                'subtitle' => 'Institutional agreements',
                'summary' => 'DRIC strengthens UMSS relationships with higher education and research institutions, public, private and social sectors, international organizations, foundations, and education support agencies.',
                'body' => 'Signed agreements promote academic exchange, interinstitutional cooperation, and research mechanisms with greater impact, efficiency, and functional results.',
            ],
        ]);

        $cards = $this->upsertSection($page, 'agreements.cards', 'agreements_cards', 2, $languages, [
            'es' => ['title' => 'Accesos de convenios', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Agreement links', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        $this->upsertBlock($hero, 'agreements.hero-image', 'image', 1, $languages, [
            'es' => ['title' => 'Imagen principal de convenios', 'summary' => null],
            'en' => ['title' => 'Main agreements image', 'summary' => null],
        ]);

        $this->upsertBlock($cards, 'agreements.card-action', 'action_label', 0, $languages, [
            'es' => ['title' => 'Ver convenios', 'summary' => null],
            'en' => ['title' => 'View agreements', 'summary' => null],
        ]);

        $this->upsertBlock($hero, 'agreements.procedure', 'procedure_link', 2, $languages, [
            'es' => ['title' => 'Procedimiento para suscribir un convenio con la UMSS', 'summary' => null],
            'en' => ['title' => 'Procedure to sign an agreement with UMSS', 'summary' => null],
        ], [
            'url' => 'https://dric.umss.edu.bo/wp-content/uploads/2021/11/proconv.pdf',
        ]);

        foreach ($this->cards() as $index => $card) {
            $this->upsertBlock($cards, 'agreements.card.'.($index + 1), 'agreement_card', $index + 1, $languages, [
                'es' => [
                    'title' => $card['title_es'],
                    'summary' => $card['description_es'],
                ],
                'en' => [
                    'title' => $card['title_en'],
                    'summary' => $card['description_en'],
                ],
            ], [
                'href' => $card['href'],
            ]);
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => [
                'title' => 'Convenios suscritos por la UMSS',
                'menu_title' => 'Convenios',
                'subtitle' => 'Convenios institucionales',
                'summary' => 'La DRIC fortalece el vínculo de la UMSS con instituciones de educación superior e investigación, sectores público, privado y social, organismos internacionales, fundaciones y agencias de apoyo a la educación.',
                'body' => null,
            ],
            'en' => [
                'title' => 'Agreements signed by UMSS',
                'menu_title' => 'Agreements',
                'subtitle' => 'Institutional agreements',
                'summary' => 'DRIC strengthens UMSS relationships with higher education and research institutions, public, private and social sectors, international organizations, foundations, and education support agencies.',
                'body' => null,
            ],
        ];
    }

    private function cards(): array
    {
        return [
            [
                'title_es' => 'Convenios UMSS',
                'title_en' => 'UMSS Agreements',
                'description_es' => 'Acuerdos institucionales supervisados por la DRIC para fortalecer la cooperación académica, científica y administrativa.',
                'description_en' => 'Institutional agreements supervised by DRIC to strengthen academic, scientific, and administrative cooperation.',
                'href' => 'https://conveniosdric.umss.edu.bo/convenios',
            ],
            [
                'title_es' => 'Otros convenios suscritos',
                'title_en' => 'Other signed agreements',
                'description_es' => 'Convenios suscritos con instituciones que no han sido revisados directamente por la DRIC.',
                'description_en' => 'Agreements signed with institutions that have not been directly reviewed by DRIC.',
                'href' => '/convenios/otros',
            ],
            [
                'title_es' => 'Convenios CEUB y Gobierno de Bolivia',
                'title_en' => 'CEUB and Government of Bolivia Agreements',
                'description_es' => 'Acuerdos suscritos por el Gobierno de Bolivia y el Comité Ejecutivo de la Universidad Boliviana.',
                'description_en' => 'Agreements signed by the Government of Bolivia and the Executive Committee of the Bolivian University.',
                'href' => '/convenios/ceub-gobierno',
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

        foreach ($translations as $locale => $values) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $values['title'],
                    'subtitle' => null,
                    'summary' => $values['summary'],
                    'body' => null,
                ]
            );
        }
    }
}
