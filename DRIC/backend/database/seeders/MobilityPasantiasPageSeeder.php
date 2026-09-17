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

class MobilityPasantiasPageSeeder extends Seeder
{
    public function run(): void
    {
        $parent = Page::where('slug', 'becas-movilidad')->first();

        $page = Page::updateOrCreate(
            ['slug' => 'movilidad-pasantias'],
            [
                'parent_id' => $parent?->id,
                'page_type' => 'mobility_catalog',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => 2,
                'created_by' => null,
                'updated_by' => null,
            ]
        );

        $es = Language::where('code', 'es')->firstOrFail();
        $en = Language::where('code', 'en')->firstOrFail();

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $es->id],
            [
                'title' => 'Programas de movilidad y pasantías',
                'menu_title' => 'Movilidad y pasantías',
                'subtitle' => 'Experiencias internacionales para estudiantes, docentes y administrativos',
                'summary' => 'Explora convocatorias activas y programas institucionales para cursar asignaturas, investigar, capacitarte o fortalecer redes académicas con universidades y organismos aliados.',
                'body' => null,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'language_id' => $en->id],
            [
                'title' => 'Mobility and internship programs',
                'menu_title' => 'Mobility and internships',
                'subtitle' => 'International experiences for students, faculty and administrative staff',
                'summary' => 'Explore current calls and institutional programs to take courses, conduct research, train professionally, or strengthen academic networks with partner universities and organizations.',
                'body' => null,
            ]
        );

        $studentSection = $this->upsertSection(
            $page,
            $es,
            $en,
            'mobility.estudiantes',
            'estudiantes',
            1,
            'Estudiantes',
            'Student mobility',
            'Programas para intercambio semestral, pasantías remuneradas, estancias de investigación y oportunidades de internacionalización académica.',
            'Programs for semester exchange, paid internships, research stays and academic internationalization opportunities.'
        );

        $staffSection = $this->upsertSection(
            $page,
            $es,
            $en,
            'mobility.docentes-administrativos',
            'docentes-administrativos',
            2,
            'Docentes y administrativos',
            'Faculty and administrative staff',
            'Movilidad académica, administrativa y de formación continua para fortalecer cooperación, gestión universitaria y redes internacionales.',
            'Academic, administrative and continuing-training mobility to strengthen cooperation, university management and international networks.'
        );

        $this->syncPrograms($studentSection, $es, $en, $this->studentPrograms());
        $this->syncPrograms($staffSection, $es, $en, $this->staffPrograms());
    }

    private function upsertSection(Page $page, Language $es, Language $en, string $sectionKey, string $trackId, int $sortOrder, string $titleEs, string $titleEn, string $summaryEs, string $summaryEn): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $sectionKey],
            [
                'section_type' => 'mobility_track',
                'settings' => [
                    'editable' => true,
                    'track_id' => $trackId,
                ],
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]
        );

        SectionTranslation::updateOrCreate(
            ['section_id' => $section->id, 'language_id' => $es->id],
            [
                'title' => $titleEs,
                'subtitle' => null,
                'summary' => $summaryEs,
                'body' => null,
            ]
        );

        SectionTranslation::updateOrCreate(
            ['section_id' => $section->id, 'language_id' => $en->id],
            [
                'title' => $titleEn,
                'subtitle' => null,
                'summary' => $summaryEn,
                'body' => null,
            ]
        );

        return $section;
    }

    private function syncPrograms(Section $section, Language $es, Language $en, array $programs): void
    {
        foreach ($programs as $index => $program) {
            $block = ContentBlock::updateOrCreate(
                ['section_id' => $section->id, 'link_url' => $program['link_url']],
                [
                    'block_type' => 'mobility_program',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'data' => [
                        'slug' => $program['slug'],
                        'tag' => $program['tag_es'],
                        'conditions_es' => $program['conditions_es'],
                        'conditions_en' => $program['conditions_en'],
                        'track_id' => $program['track_id'],
                        'editable' => true,
                    ],
                    'media_asset_id' => null,
                ]
            );

            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $es->id],
                [
                    'title' => $program['title_es'],
                    'subtitle' => $program['tag_es'],
                    'summary' => $program['summary_es'],
                    'body' => null,
                ]
            );

            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $en->id],
                [
                    'title' => $program['title_en'],
                    'subtitle' => $program['tag_en'],
                    'summary' => $program['summary_en'],
                    'body' => null,
                ]
            );
        }
    }

    private function studentPrograms(): array
    {
        return [
            $this->program('estudiantes', 'convenio-interinstitucional-estudiantes', 'Convenio Interinstitucional', 'Interinstitutional Agreement', 'Convenio activo', 'Active agreement', 'Movilidad estudiantil mediante convenios vigentes de la UMSS con universidades socias.', 'Student mobility through current UMSS agreements with partner universities.', ['La universidad de origen cubre el traslado internacional.', 'La universidad de destino cubre manutención, alojamiento y estudios.'], ['The home university covers international travel.', 'The host university covers living expenses, accommodation and academic fees.']),
            $this->program('estudiantes', 'programa-erasmus-icm-estudiantes', 'Programa ERASMUS+/ICM', 'ERASMUS+/ICM Programme', 'Unión Europea', 'European Union', 'Movilidad académica con universidades europeas aliadas dentro de Erasmus+ International Credit Mobility.', 'Academic mobility with European partner universities through Erasmus+ International Credit Mobility.', ['Plazas, áreas y beneficios dependen de cada convocatoria.', 'Requiere postulación formal ante la DRIC.'], ['Places, areas and benefits depend on each call.', 'A formal application through DRIC is required.']),
            $this->program('estudiantes', 'programa-escala-de-estudiantes-de-grado-peeg-de-augm-estudiantes', 'Programa Escala de Estudiantes de Grado (PEEG) de AUGM', 'AUGM Undergraduate Student Scale Programme (PEEG)', 'AUGM', 'AUGM', 'Intercambio semestral de grado entre universidades miembro de la Asociación de Universidades Grupo Montevideo.', 'Semester-long undergraduate exchange among member universities of the Montevideo Group Association.', ['La universidad de origen cubre el traslado.', 'La universidad receptora cubre alojamiento y alimentación.'], ['The home university covers travel.', 'The host university covers accommodation and meals.']),
            $this->program('estudiantes', 'programa-marca-mercosur-estudiantes', 'Programa Marca Mercosur', 'MARCA Mercosur Programme', 'Carreras acreditadas', 'Accredited programmes', 'Movilidad para estudiantes de carreras acreditadas en el sistema regional del MERCOSUR.', 'Mobility for students from degree programmes accredited within the MERCOSUR regional system.', ['Solo participan carreras acreditadas.', 'Los interesados deben consultar en su carrera la convocatoria vigente.'], ['Only accredited degree programmes participate.', 'Interested students should check the current call with their programme office.']),
            $this->program('estudiantes', 'programa-de-movilidad-estudiantil-pme-criscos-estudiantes', 'Programa de Movilidad Estudiantil (PME) CRISCOS', 'CRISCOS Student Mobility Programme (PME)', 'CRISCOS', 'CRISCOS', 'Movilidad regional para cursar asignaturas homologables en universidades miembro de CRISCOS.', 'Regional mobility to take transferable courses at CRISCOS member universities.', ['Dirigido a estudiantes de pregrado.', 'Las condiciones se publican en cada convocatoria.'], ['For undergraduate students.', 'Conditions are published in each call.']),
            $this->program('estudiantes', 'programa-puma-crula-auf-estudiantes', 'Programa PUMA CRULA-AUF', 'PUMA CRULA-AUF Programme', 'Francofonía', 'Francophonie', 'Movilidad presencial promovida por universidades latinoamericanas miembros de la AUF.', 'In-person mobility promoted by Latin American universities that belong to AUF.', ['Experiencia de internacionalización y homologación de asignaturas.', 'Plazas definidas por convocatoria.'], ['Internationalization experience with course recognition.', 'Places are defined by each call.']),
            $this->program('estudiantes', 'pasantias-remuneradas-iaeste-bolivia-estudiantes', 'Pasantías Remuneradas IAESTE Bolivia', 'IAESTE Bolivia Paid Internships', 'Pasantías', 'Internships', 'Pasantías técnicas remuneradas en empresas e instituciones internacionales mediante IAESTE.', 'Paid technical internships in international companies and institutions through IAESTE.', ['Convocatorias por plazas específicas.', 'Perfil y requisitos varían por oferta.'], ['Calls are organized by specific positions.', 'Profile and requirements vary by offer.']),
            $this->program('estudiantes', 'pasantias-remuneradas-bid-estudiantes', 'Pasantías Remuneradas BID', 'IDB Paid Internships', 'Grupo BID', 'IDB Group', 'Oportunidades remuneradas para adquirir experiencia profesional en desarrollo internacional.', 'Paid opportunities to gain professional experience in international development.', ['Pasantías en Washington D.C. y oficinas regionales.', 'Cronogramas definidos por el Grupo BID.'], ['Internships in Washington, D.C. and regional offices.', 'Schedules are defined by the IDB Group.']),
            $this->program('estudiantes', 'global-connect-fellowship-gcf-singapur-estudiantes', 'Global Connect Fellowship (GCF) - Singapur', 'Global Connect Fellowship (GCF) - Singapore', 'Investigación', 'Research', 'Estancia de investigación de alto nivel en la Nanyang Technological University de Singapur.', 'High-level research stay at Nanyang Technological University in Singapore.', ['Dirigido a estudiantes destacados de grado y maestría.', 'La postulación se realiza en el sitio oficial de NTU.'], ['For outstanding undergraduate and master students.', 'Applications are submitted through the official NTU site.']),
        ];
    }

    private function staffPrograms(): array
    {
        return [
            $this->program('docentes-administrativos', 'convenio-interinstitucional-docentes-administrativos', 'Convenio Interinstitucional', 'Interinstitutional Agreement', 'Gestión institucional', 'Institutional pathway', 'Movilidad docente o administrativa mediante convenios vigentes de cooperación interuniversitaria.', 'Faculty or administrative mobility through current interuniversity cooperation agreements.', ['El interesado debe contactar a la DRIC.', 'La elegibilidad depende del convenio vigente y la institución receptora.'], ['Interested applicants should contact DRIC.', 'Eligibility depends on the active agreement and host institution.']),
            $this->program('docentes-administrativos', 'programa-de-movilidad-academica-administrativa-pmaa-criscos-docentes-administrativos', 'Programa de Movilidad Académica Administrativa (PMAA) CRISCOS', 'CRISCOS Academic and Administrative Mobility Programme (PMAA)', 'CRISCOS', 'CRISCOS', 'Intercambio regional para docentes, investigadores, gestores y personal administrativo.', 'Regional exchange for faculty, researchers, managers and administrative staff.', ['La universidad de origen cubre el traslado.', 'La universidad receptora cubre estadía según convocatoria.'], ['The home university covers travel.', 'The host university covers the stay according to each call.']),
            $this->program('docentes-administrativos', 'programa-escala-docente-ped-de-augm-docentes-administrativos', 'Programa Escala Docente (PED) de AUGM', 'AUGM Faculty Scale Programme (PED)', 'AUGM', 'AUGM', 'Movilidad académica docente para fortalecer cooperación, docencia, investigación y redes regionales.', 'Faculty mobility to strengthen cooperation, teaching, research and regional networks.', ['Dirigido a docentes de universidades miembro.', 'Las áreas y destinos dependen de cada convocatoria.'], ['For faculty from member universities.', 'Areas and destinations depend on each call.']),
            $this->program('docentes-administrativos', 'programa-escala-de-gestores-y-administradores-pegya-de-augm-docentes-administrativos', 'Programa Escala de Gestores y Administradores (PEGyA) de AUGM', 'AUGM Managers and Administrators Scale Programme (PEGyA)', 'Gestión universitaria', 'University management', 'Movilidad para directivos, gestores y administrativos de universidades miembro de AUGM.', 'Mobility for executives, managers and administrative staff from AUGM member universities.', ['La universidad de origen cubre el traslado internacional.', 'La universidad receptora cubre alojamiento y alimentación.'], ['The home university covers international travel.', 'The host university covers accommodation and meals.']),
            $this->program('docentes-administrativos', 'programa-erasmus-icm-docentes-administrativos', 'Programa Erasmus+ ICM', 'Erasmus+ ICM Programme', 'Unión Europea', 'European Union', 'Movilidad docente y administrativa con universidades europeas aliadas bajo Erasmus+ ICM.', 'Faculty and administrative mobility with European partner universities under Erasmus+ ICM.', ['Beneficios y duración dependen de cada universidad socia.', 'La postulación se presenta ante la DRIC.'], ['Benefits and duration depend on each partner university.', 'Applications are submitted through DRIC.']),
            $this->program('docentes-administrativos', 'intercoonecta-docentes-administrativos', 'INTERCOONECTA', 'INTERCOONECTA', 'Cooperación Española', 'Spanish Cooperation', 'Formación técnica especializada y gestión de conocimiento para el desarrollo en América Latina y el Caribe.', 'Specialized technical training and knowledge management for development in Latin America and the Caribbean.', ['Actividades presenciales y virtuales.', 'Dirigido principalmente a empleados públicos y profesionales de administraciones públicas.'], ['In-person and virtual activities.', 'Mainly for public employees and public-administration professionals.']),
        ];
    }

    private function program(string $trackId, string $slug, string $titleEs, string $titleEn, string $tagEs, string $tagEn, string $summaryEs, string $summaryEn, array $conditionsEs, array $conditionsEn): array
    {
        return [
            'track_id' => $trackId,
            'slug' => $slug,
            'title_es' => $titleEs,
            'title_en' => $titleEn,
            'tag_es' => $tagEs,
            'tag_en' => $tagEn,
            'summary_es' => $summaryEs,
            'summary_en' => $summaryEn,
            'conditions_es' => $conditionsEs,
            'conditions_en' => $conditionsEn,
            'link_url' => "/becas-movilidad/movilidad-pasantias/{$slug}",
        ];
    }
}
