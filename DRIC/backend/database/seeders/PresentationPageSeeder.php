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

class PresentationPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'presentacion')->firstOrFail();

        $page->update([
            'status' => 'published',
            'published_at' => $page->published_at ?? now(),
        ]);

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        $this->upsertPageTranslations($page, $languages);

        $history = $this->upsertSection($page, 'presentation.history', 'presentation_history', 1, $languages, [
            'es' => [
                'title' => 'Una visión internacional desde la UMSS',
                'subtitle' => 'Historia institucional',
                'summary' => 'La Dirección de Relaciones Internacionales y Convenios fue creada el 7 de enero de 1988, con el rango de Secretaría. El año 1995 se instituye como Departamento y en noviembre de 1997 se crea la actual Dirección.',
            ],
            'en' => [
                'title' => 'International vision from UMSS',
                'subtitle' => 'Institutional history',
                'summary' => 'The Directorate of International Relations and Agreements was created on January 7, 1988, with the rank of Secretariat. In 1995 it was established as a Department, and in November 1997 the current Directorate was created.',
            ],
        ]);

        $missionPurpose = $this->upsertSection($page, 'presentation.mission-purpose', 'mission_purpose', 2, $languages, [
            'es' => ['title' => 'Misión y propósito', 'subtitle' => null, 'summary' => null],
            'en' => ['title' => 'Mission and purpose', 'subtitle' => null, 'summary' => null],
        ]);

        $structure = $this->upsertSection($page, 'presentation.structure', 'organization_structure', 3, $languages, [
            'es' => [
                'title' => 'Dirección DRIC',
                'subtitle' => 'Estructura',
                'summary' => 'La DRIC depende directamente del Rectorado. Para el cumplimiento de sus funciones, se estructura de la siguiente manera:',
            ],
            'en' => [
                'title' => 'DRIC Directorate',
                'subtitle' => 'Organizational structure',
                'summary' => 'DRIC reports directly to the Rector\'s Office. To fulfill its functions, it is structured as follows:',
            ],
        ]);

        $this->upsertBlock($history, 'presentation.history-image', 'image', 1, $languages, [
            'es' => ['title' => 'Imagen del equipo DRIC', 'summary' => null],
            'en' => ['title' => 'DRIC team image', 'summary' => null],
        ]);

        $this->upsertBlock($missionPurpose, 'presentation.mission', 'mission', 1, $languages, [
            'es' => [
                'title' => 'Misión',
                'summary' => 'Promover, coordinar y canalizar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS, en beneficio de los procesos de enseñanza-aprendizaje, investigación científica y tecnológica, interacción social y fortalecimiento institucional.',
            ],
            'en' => [
                'title' => 'Mission',
                'summary' => 'To promote, coordinate and channel international and national cooperation, as well as UMSS interinstitutional coordination, in support of teaching and learning processes, scientific and technological research, social engagement and institutional strengthening.',
            ],
        ]);

        $this->upsertBlock($missionPurpose, 'presentation.purpose', 'purpose', 2, $languages, [
            'es' => [
                'title' => 'Propósito',
                'summary' => 'Es propósito fundamental de la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón explorar de manera organizada y sistemática las oportunidades de cooperación internacional y de coordinación interinstitucional.',
            ],
            'en' => [
                'title' => 'Purpose',
                'summary' => 'The main purpose of the Directorate of International Relations and Agreements of Universidad Mayor de San Simón is to explore international cooperation and interinstitutional coordination opportunities in an organized and systematic way.',
            ],
        ]);

        $this->upsertBlock($structure, 'presentation.structure-items', 'structure_items', 1, $languages, [
            'es' => ['title' => 'Áreas de la estructura', 'summary' => null],
            'en' => ['title' => 'Structure areas', 'summary' => null],
        ], [
            'items_es' => [
                'Dirección Ejecutiva',
                'Departamento de Convenios, Movilidad y Becas',
                'Departamento de Internacionalización y Proyectos',
            ],
            'items_en' => [
                'Executive Directorate',
                'Department of Agreements, Mobility and Scholarships',
                'Department of Internationalization and Projects',
            ],
        ]);

        $this->upsertBlock($structure, 'presentation.director', 'director', 2, $languages, [
            'es' => ['title' => 'Director: Mgr. Omar Morales Delgadillo', 'summary' => null],
            'en' => ['title' => 'Director: Mgr. Omar Morales Delgadillo', 'summary' => null],
        ], [
            'emails' => ['director-dric@umss.edu.bo', 'rrii@umss.edu.bo'],
        ]);

        $this->upsertBlock($structure, 'presentation.agreements-team', 'staff_group', 3, $languages, [
            'es' => ['title' => 'Convenios, Movilidad y Becas', 'summary' => null],
            'en' => ['title' => 'Agreements, Mobility and Scholarships', 'summary' => null],
        ], [
            'people_es' => ['Jefe del departamento: Mgr. Giovanna Maldonado Moscoso', 'Mgr. Silvia del Pilar Arze'],
            'people_en' => ['Head of Department: Mgr. Giovanna Maldonado Moscoso', 'Mgr. Silvia del Pilar Arze'],
        ]);

        $this->upsertBlock($structure, 'presentation.projects-team', 'staff_group', 4, $languages, [
            'es' => ['title' => 'Internacionalización y Proyectos', 'summary' => null],
            'en' => ['title' => 'Internationalization and Projects', 'summary' => null],
        ], [
            'people_es' => ['Jefe del Departamento: Mgr. Daniel Vasquez Torrez', 'Ing. John Medina'],
            'people_en' => ['Head of Department: Mgr. Daniel Vasquez Torrez', 'Eng. John Medina'],
        ]);

        $this->upsertBlock($structure, 'presentation.director-image', 'image', 5, $languages, [
            'es' => ['title' => 'Imagen del director', 'summary' => null],
            'en' => ['title' => 'Director image', 'summary' => null],
        ]);
    }

    private function upsertPageTranslations(Page $page, $languages): void
    {
        $translations = [
            'es' => [
                'title' => 'Presentación',
                'menu_title' => 'Presentación',
                'subtitle' => null,
                'summary' => 'La Dirección de Relaciones Internacionales y Convenios promueve la cooperación, movilidad, proyectos y oportunidades académicas internacionales de la Universidad Mayor de San Simón.',
                'body' => null,
            ],
            'en' => [
                'title' => 'About DRIC',
                'menu_title' => 'About DRIC',
                'subtitle' => null,
                'summary' => 'The Directorate of International Relations and Agreements promotes cooperation, mobility, projects and international academic opportunities for Universidad Mayor de San Simón.',
                'body' => null,
            ],
        ];

        foreach ($translations as $locale => $values) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }
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
