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

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'inicio')->firstOrFail();

        $page->update([
            'status' => 'published',
            'published_at' => $page->published_at ?? now(),
        ]);

        $es = Language::where('code', 'es')->firstOrFail();
        $en = Language::where('code', 'en')->firstOrFail();

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $es->id],
            [
                'title' => 'Inicio',
                'menu_title' => 'Inicio',
                'subtitle' => 'Conectando mentes globales',
                'summary' => 'Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.',
                'body' => null,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $en->id],
            [
                'title' => 'Home',
                'menu_title' => 'Home',
                'subtitle' => 'Connecting global minds',
                'summary' => 'International Relations and Agreements Office of Universidad Mayor de San Simón.',
                'body' => null,
            ]
        );

        $sections = [
            [
                'key' => 'home.hero',
                'type' => 'hero',
                'order' => 1,
                'settings' => [
                    'theme' => 'dark',
                    'background' => '/images/hero/hero-blur-bg.jpg',
                    'animation' => 'fade-up',
                    'layout' => 'centered',
                ],
                'es' => [
                    'title' => 'Conectando mentes globales',
                    'subtitle' => 'Formación académica de excelencia con proyección internacional.',
                    'summary' => 'Impulsamos oportunidades académicas, cooperación internacional y crecimiento profesional.',
                ],
                'en' => [
                    'title' => 'Connecting global minds',
                    'subtitle' => 'Academic excellence with international projection.',
                    'summary' => 'We promote academic opportunities, international cooperation, and professional growth.',
                ],
                'blocks' => [
                    [
                        'type' => 'hero_content',
                        'order' => 1,
                        'link_url' => '/presentacion',
                        'data' => [
                            'badge' => 'Presentación',
                            'secondaryLink' => '/becas-movilidad',
                        ],
                        'es' => [
                            'title' => 'Conectando mentes globales',
                            'subtitle' => 'Formación académica de excelencia con proyección internacional.',
                            'summary' => 'Conoce las oportunidades que la DRIC ofrece para fortalecer tu futuro académico.',
                            'cta_label' => 'Convenios',
                            'secondary_cta_label' => 'Becas y movilidad',
                        ],
                        'en' => [
                            'title' => 'Connecting global minds',
                            'subtitle' => 'Academic excellence with international projection.',
                            'summary' => 'Discover the opportunities DRIC offers to strengthen your academic future.',
                            'cta_label' => 'Agreements',
                            'secondary_cta_label' => 'Scholarships and mobility',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'home.scholarships',
                'type' => 'scholarship_country_grid',
                'order' => 2,
                'settings' => [
                    'theme' => 'dark',
                    'animation' => 'stagger-cards',
                    'layout' => 'masonry-grid',
                ],
                'es' => [
                    'title' => 'Convocatoria de Becas',
                    'subtitle' => 'Explora oportunidades académicas internacionales.',
                    'summary' => 'Accede a convocatorias de becas, movilidad e intercambio académico.',
                ],
                'en' => [
                    'title' => 'Scholarship Calls',
                    'subtitle' => 'Explore international academic opportunities.',
                    'summary' => 'Access scholarship, mobility, and academic exchange opportunities.',
                ],
                'blocks' => [
                    ['country' => 'Alemania', 'country_en' => 'Germany', 'image' => '/images/scholarships/germany.jpg'],
                    ['country' => 'Francia', 'country_en' => 'France', 'image' => '/images/scholarships/france.jpg'],
                    ['country' => 'Corea del Sur', 'country_en' => 'South Korea', 'image' => '/images/scholarships/south-korea.jpg'],
                    ['country' => 'Italia', 'country_en' => 'Italy', 'image' => '/images/scholarships/italy.jpg'],
                    ['country' => 'Japón', 'country_en' => 'Japan', 'image' => '/images/scholarships/japan.jpg'],
                    ['country' => 'Holanda', 'country_en' => 'Netherlands', 'image' => '/images/scholarships/netherlands.jpg'],
                    ['country' => 'Suecia', 'country_en' => 'Sweden', 'image' => '/images/scholarships/sweden.jpg'],
                    ['country' => 'Suiza', 'country_en' => 'Switzerland', 'image' => '/images/scholarships/switzerland.jpg'],
                    ['country' => 'China', 'country_en' => 'China', 'image' => '/images/scholarships/china.jpg'],
                ],
            ],
            [
                'key' => 'home.about',
                'type' => 'about_dric',
                'order' => 3,
                'settings' => [
                    'theme' => 'dark',
                    'animation' => 'fade-up',
                    'layout' => 'text-image',
                    'image' => '/images/administration/dric-team.jpg',
                ],
                'es' => [
                    'title' => 'Conócenos',
                    'subtitle' => 'Dirección de Relaciones Internacionales y Convenios',
                    'summary' => 'La DRIC fortalece la internacionalización universitaria mediante convenios, movilidad, cooperación y vinculación académica.',
                ],
                'en' => [
                    'title' => 'About us',
                    'subtitle' => 'International Relations and Agreements Office',
                    'summary' => 'DRIC strengthens university internationalization through agreements, mobility, cooperation, and academic partnerships.',
                ],
                'blocks' => [
                    [
                        'type' => 'tag_list',
                        'order' => 1,
                        'data' => [
                            'tags' => ['Convenios', 'Movilidad', 'Cooperación', 'Becas', 'Internacionalización'],
                        ],
                        'es' => [
                            'title' => 'Áreas de trabajo',
                            'summary' => 'Gestión de oportunidades internacionales para la comunidad universitaria.',
                        ],
                        'en' => [
                            'title' => 'Work areas',
                            'summary' => 'Management of international opportunities for the university community.',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'home.recent_agreements',
                'type' => 'recent_agreements',
                'order' => 4,
                'settings' => [
                    'theme' => 'dark',
                    'animation' => 'card-reveal',
                    'layout' => 'three-card-grid',
                ],
                'es' => [
                    'title' => 'Acuerdos recientes',
                    'subtitle' => 'Convenios y alianzas institucionales.',
                    'summary' => 'Conoce las acciones recientes de cooperación nacional e internacional.',
                ],
                'en' => [
                    'title' => 'Recent agreements',
                    'subtitle' => 'Institutional agreements and partnerships.',
                    'summary' => 'Learn about recent national and international cooperation actions.',
                ],
                'blocks' => [
                    ['title_es' => 'Cooperación académica internacional', 'title_en' => 'International academic cooperation', 'image' => '/images/agreements/agreement-1.jpg'],
                    ['title_es' => 'Alianzas estratégicas', 'title_en' => 'Strategic partnerships', 'image' => '/images/agreements/agreement-2.jpg'],
                    ['title_es' => 'Vinculación institucional', 'title_en' => 'Institutional relations', 'image' => '/images/agreements/agreement-3.jpg'],
                ],
            ],
            [
                'key' => 'home.director',
                'type' => 'director_mission_purpose',
                'order' => 5,
                'settings' => [
                    'theme' => 'dark',
                    'animation' => 'split-reveal',
                    'layout' => 'director-card',
                    'image' => '/images/administration/director.jpg',
                ],
                'es' => [
                    'title' => 'Director: Oscar Edwin Alba Salazar',
                    'subtitle' => 'Dirección de Relaciones Internacionales y Convenios',
                    'summary' => 'La DRIC depende directamente del Rectorado para el cumplimiento de sus funciones.',
                ],
                'en' => [
                    'title' => 'Director: Oscar Edwin Alba Salazar',
                    'subtitle' => 'International Relations and Agreements Office',
                    'summary' => 'DRIC reports directly to the Rectorate in the fulfillment of its functions.',
                ],
                'blocks' => [
                    [
                        'type' => 'mission',
                        'order' => 1,
                        'es' => [
                            'title' => 'Misión',
                            'summary' => 'Promover, coordinar y consolidar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS.',
                        ],
                        'en' => [
                            'title' => 'Mission',
                            'summary' => 'To promote, coordinate, and consolidate international and national cooperation, as well as UMSS interinstitutional coordination.',
                        ],
                    ],
                    [
                        'type' => 'purpose',
                        'order' => 2,
                        'es' => [
                            'title' => 'Propósito',
                            'summary' => 'Fortalecer la internacionalización universitaria mediante convenios, proyectos, becas, movilidad y cooperación académica.',
                        ],
                        'en' => [
                            'title' => 'Purpose',
                            'summary' => 'To strengthen university internationalization through agreements, projects, scholarships, mobility, and academic cooperation.',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'home.stats',
                'type' => 'stats',
                'order' => 6,
                'settings' => [
                    'theme' => 'blue-glow',
                    'animation' => 'count-up',
                    'layout' => 'three-columns',
                ],
                'es' => [
                    'title' => 'Resultados institucionales',
                    'subtitle' => 'Impacto de la cooperación internacional.',
                    'summary' => 'Indicadores destacados de la gestión institucional.',
                ],
                'en' => [
                    'title' => 'Institutional results',
                    'subtitle' => 'Impact of international cooperation.',
                    'summary' => 'Key indicators of institutional management.',
                ],
                'blocks' => [
                    ['value' => '2700+', 'label_es' => 'Convenios acordados', 'label_en' => 'Agreements signed'],
                    ['value' => '96%', 'label_es' => 'Estudiantes satisfechos', 'label_en' => 'Satisfied students'],
                    ['value' => '37+', 'label_es' => 'Años de experiencia', 'label_en' => 'Years of experience'],
                ],
            ],
            [
                'key' => 'home.faq',
                'type' => 'faq',
                'order' => 7,
                'settings' => [
                    'theme' => 'dark-blue',
                    'animation' => 'accordion',
                    'layout' => 'image-accordion',
                    'image' => '/images/testimonials/students-faq.jpg',
                ],
                'es' => [
                    'title' => 'FAQ',
                    'subtitle' => 'Encuentra respuestas a preguntas frecuentes acerca de nuestros programas.',
                    'summary' => 'Información esencial para estudiantes nacionales, extranjeros y visitantes.',
                ],
                'en' => [
                    'title' => 'FAQ',
                    'subtitle' => 'Find answers to frequently asked questions about our programs.',
                    'summary' => 'Essential information for national and international students and visitors.',
                ],
                'blocks' => [
                    [
                        'question_es' => '¿Qué es la DRIC y cuál es su función dentro de la universidad?',
                        'answer_es' => 'La DRIC gestiona relaciones internacionales, convenios, cooperación académica y oportunidades de movilidad para la comunidad universitaria.',
                        'question_en' => 'What is DRIC and what is its role within the university?',
                        'answer_en' => 'DRIC manages international relations, agreements, academic cooperation, and mobility opportunities for the university community.',
                    ],
                    [
                        'question_es' => '¿Qué tipos de becas internacionales ofrece la DRIC?',
                        'answer_es' => 'La DRIC difunde convocatorias de becas de pregrado, posgrado, movilidad, pasantías y programas académicos internacionales.',
                        'question_en' => 'What types of international scholarships does DRIC offer?',
                        'answer_en' => 'DRIC shares calls for undergraduate, graduate, mobility, internship, and international academic programs.',
                    ],
                    [
                        'question_es' => '¿En qué países puedo realizar intercambios académicos?',
                        'answer_es' => 'Las oportunidades dependen de los convenios vigentes, convocatorias activas y requisitos de cada institución extranjera.',
                        'question_en' => 'In which countries can I do academic exchanges?',
                        'answer_en' => 'Opportunities depend on active agreements, current calls, and requirements from each foreign institution.',
                    ],
                    [
                        'question_es' => '¿Cómo puedo contactar con la DRIC para recibir asesoramiento personalizado?',
                        'answer_es' => 'Puedes comunicarte mediante los canales oficiales de contacto o solicitar orientación según el programa de interés.',
                        'question_en' => 'How can I contact DRIC for personalized guidance?',
                        'answer_en' => 'You can contact DRIC through official channels or request guidance according to your program of interest.',
                    ],
                ],
            ],
            [
                'key' => 'home.final_cta',
                'type' => 'final_cta',
                'order' => 8,
                'settings' => [
                    'theme' => 'dark-blur',
                    'background' => '/images/hero/hero-blur-bg.jpg',
                    'animation' => 'fade-up',
                    'layout' => 'centered-cta',
                ],
                'es' => [
                    'title' => 'Da el siguiente paso en tu camino académico',
                    'subtitle' => 'Descubre oportunidades que pueden transformar tu futuro.',
                    'summary' => 'Agenda una cita y recibe orientación sobre programas, convenios y becas internacionales.',
                ],
                'en' => [
                    'title' => 'Take the next step in your academic journey',
                    'subtitle' => 'Discover opportunities that can transform your future.',
                    'summary' => 'Schedule an appointment and receive guidance on programs, agreements, and international scholarships.',
                ],
                'blocks' => [
                    [
                        'type' => 'cta_button',
                        'order' => 1,
                        'link_url' => '/contacto',
                        'es' => [
                            'title' => 'Agenda una cita',
                            'summary' => 'Recibe asesoramiento personalizado.',
                            'cta_label' => 'Agenda una cita',
                        ],
                        'en' => [
                            'title' => 'Schedule an appointment',
                            'summary' => 'Receive personalized guidance.',
                            'cta_label' => 'Schedule an appointment',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionData) {
            $section = Section::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'section_key' => $sectionData['key'],
                ],
                [
                    'section_type' => $sectionData['type'],
                    'sort_order' => $sectionData['order'],
                    'is_active' => true,
                    'settings' => $sectionData['settings'],
                ]
            );

            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $es->id],
                [
                    'title' => $sectionData['es']['title'],
                    'subtitle' => $sectionData['es']['subtitle'] ?? null,
                    'summary' => $sectionData['es']['summary'] ?? null,
                    'body' => $sectionData['es']['body'] ?? null,
                ]
            );

            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $en->id],
                [
                    'title' => $sectionData['en']['title'],
                    'subtitle' => $sectionData['en']['subtitle'] ?? null,
                    'summary' => $sectionData['en']['summary'] ?? null,
                    'body' => $sectionData['en']['body'] ?? null,
                ]
            );

            foreach ($sectionData['blocks'] as $index => $blockData) {
                $blockType = $blockData['type'] ?? $sectionData['type'] . '_item';
                $sortOrder = $blockData['order'] ?? ($index + 1);

                $block = ContentBlock::updateOrCreate(
                    [
                        'section_id' => $section->id,
                        'block_type' => $blockType,
                        'sort_order' => $sortOrder,
                    ],
                    [
                        'is_active' => true,
                        'link_url' => $blockData['link_url'] ?? null,
                        'media_asset_id' => null,
                        'data' => $this->cleanBlockData($blockData),
                    ]
                );

                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $es->id],
                    [
                        'title' => $blockData['es']['title'] ?? $blockData['title_es'] ?? $blockData['country'] ?? $blockData['question_es'] ?? $blockData['label_es'] ?? null,
                        'subtitle' => $blockData['es']['subtitle'] ?? null,
                        'summary' => $blockData['es']['summary'] ?? $blockData['answer_es'] ?? $blockData['label_es'] ?? null,
                        'body' => $blockData['es']['body'] ?? null,
                        'cta_label' => $blockData['es']['cta_label'] ?? null,
                        'secondary_cta_label' => $blockData['es']['secondary_cta_label'] ?? null,
                    ]
                );

                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $en->id],
                    [
                        'title' => $blockData['en']['title'] ?? $blockData['title_en'] ?? $blockData['country_en'] ?? $blockData['question_en'] ?? $blockData['label_en'] ?? null,
                        'subtitle' => $blockData['en']['subtitle'] ?? null,
                        'summary' => $blockData['en']['summary'] ?? $blockData['answer_en'] ?? $blockData['label_en'] ?? null,
                        'body' => $blockData['en']['body'] ?? null,
                        'cta_label' => $blockData['en']['cta_label'] ?? null,
                        'secondary_cta_label' => $blockData['en']['secondary_cta_label'] ?? null,
                    ]
                );
            }
        }
    }

    private function cleanBlockData(array $blockData): array
{
        unset(
            $blockData['es'],
            $blockData['en'],
            $blockData['title_es'],
            $blockData['title_en'],
            $blockData['country'],
            $blockData['country_en'],
            $blockData['question_es'],
            $blockData['question_en'],
            $blockData['answer_es'],
            $blockData['answer_en'],
            $blockData['label_es'],
            $blockData['label_en'],
            $blockData['order'],
            $blockData['type'],
            $blockData['link_url']
        );

        if (isset($blockData['data']) && is_array($blockData['data'])) {
            $blockData = array_merge($blockData, $blockData['data']);
            unset($blockData['data']);
        }

    return $blockData;
}
}