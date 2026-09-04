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

class NormativePageSeeder extends Seeder
{
    private const CATEGORIES = [
        'primero' => ['es' => 'Primero', 'en' => 'First'],
        'segundo' => ['es' => 'Segundo', 'en' => 'Second'],
        'tercero' => ['es' => 'Tercero', 'en' => 'Third'],
    ];

    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'normativas'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 10]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $hero = $this->section($page, 'regulations.hero', 'regulations_hero', 1, $languages, [
            'es' => ['title' => 'Normativas', 'subtitle' => 'Marco institucional', 'summary' => 'Reglamentos, resoluciones, políticas y documentos oficiales vinculados a internacionalización, movilidad académica, cooperación y convenios de la UMSS.', 'body' => null],
            'en' => ['title' => 'Regulations', 'subtitle' => 'Institutional framework', 'summary' => 'Official regulations, resolutions, policies, and institutional documents related to UMSS internationalization, academic mobility, cooperation, and agreements.', 'body' => null],
        ]);

        $list = $this->section($page, 'regulations.list', 'regulations_list', 2, $languages, [
            'es' => ['title' => 'Documentos normativos', 'subtitle' => null, 'summary' => null, 'body' => null],
            'en' => ['title' => 'Regulatory documents', 'subtitle' => null, 'summary' => null, 'body' => null],
        ]);

        unset($hero);

        if (ContentBlock::query()->where('section_id', $list->id)->exists()) {
            return;
        }

        foreach ($this->documents() as $index => $document) {
            $category = self::CATEGORIES[$document['category']];
            $block = ContentBlock::create([
                'section_id' => $list->id,
                'link_url' => 'regulations.document.'.$document['id'],
                'block_type' => 'regulation_document',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => [
                    'code' => $document['code'],
                    'category' => $document['category'],
                    'category_label_es' => $category['es'],
                    'category_label_en' => $category['en'],
                    'category_url' => 'https://dric.umss.edu.bo/document-category/'.$document['category'].'/',
                    'download_url' => $document['downloadUrl'],
                ],
            ]);

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $document['title'][$locale],
                        'subtitle' => $category[$locale],
                        'summary' => null,
                        'body' => null,
                    ]
                );
            }
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Normativas', 'menu_title' => 'Normativas', 'subtitle' => 'Marco institucional', 'summary' => 'Reglamentos, resoluciones, políticas y documentos oficiales vinculados a internacionalización, movilidad académica, cooperación y convenios de la UMSS.', 'body' => null],
            'en' => ['title' => 'Regulations', 'menu_title' => 'Regulations', 'subtitle' => 'Institutional framework', 'summary' => 'Official regulations, resolutions, policies, and institutional documents related to UMSS internationalization, academic mobility, cooperation, and agreements.', 'body' => null],
        ];
    }

    private function documents(): array
    {
        return [
            ['id' => 'red-int-augm-peepg', 'code' => 'RED-INT.-AUGM', 'category' => 'tercero', 'title' => ['es' => 'PROGRAMA ESCALA DE ESTUDIANTES DE POSGRADO (PEEPg)-AUGM.', 'en' => 'AUGM Graduate Student Scale Program (PEEPg).'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento-AUGM.pdf'],
            ['id' => 'red-int-criscos-movilidad-estudiantil', 'code' => 'RED-INT.-CRISCOS', 'category' => 'tercero', 'title' => ['es' => 'PROGRAMA DE MOVILIDAD ESTUDIANTIL - CRISCOS', 'en' => 'CRISCOS Student Mobility Program.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento-CRISCOS.pdf'],
            ['id' => 'red-int-criscos-movilidad-docente', 'code' => 'RED-INT.-CRISCOS', 'category' => 'tercero', 'title' => ['es' => 'REGLAMENTO DEL PROGRAMA DE MOVILIDAD DOCENTE-CRISCOS', 'en' => 'Regulations for the CRISCOS Faculty Mobility Program.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento_Programa_de_Movilidad_Docente_CRISCOS.pdf'],
            ['id' => 'red-int-criscos-pmaa', 'code' => 'RED-INT.-CRISCOS', 'category' => 'tercero', 'title' => ['es' => 'REGLAMENTO DEL PROGRAMA DE MOVILIDAD ACADEMICA ADMINISTRATIVA (PMAA)-CRISCOS.', 'en' => 'Regulations for the CRISCOS Administrative Academic Mobility Program (PMAA).'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/11/Reglamento_Programa_de_Movilidad_adminsitrativa_CRISCOS.pdf'],
            ['id' => 'sub-mar-2024-politica-plan-internacionalizacion', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 100/2024 Ref.: Aprobación de la Política y Plan Estratégico de Internacionalización del SUB.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 100/2024: Approval of the SUB Internationalization Policy and Strategic Plan.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/Politica_y_Plan_Estrategico_de_Internacionalizacion_del_SUB-1.pdf'],
            ['id' => 'sub-mar-2024-reglamento-convenios', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 29/2024 Aprobación del Reglamento para Elaboración y Suscripción de Convenios Locales, Nacionales e Internacionales del SUB.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 29/2024: Approval of the regulation for drafting and signing local, national, and international SUB agreements.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/Reglamento-para-Elaboracion-y-Suscripcion-de-Convenios-Locales-Nacionales-e-Internacionales-del-SUB.pdf'],
            ['id' => 'sub-mar-2024-reglamento-internacionalizacion', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 30/2024 Ref.: Aprobación del Reglamento de Internacionalización para las Universidades del SUB.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 30/2024: Approval of the internationalization regulation for SUB universities.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-30-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf'],
            ['id' => 'sub-mar-2024-relaciones-internacionales', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 31/2024 Ref.: Aprobación del reglamento General de Relaciones Internacionales.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 31/2024: Approval of the General Regulations on International Relations.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-31-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf'],
            ['id' => 'sub-mar-2024-movilidad-academica', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 32/2024 Ref.: Aprobación del Reglamento para la Movilidad Académica.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 32/2024: Approval of the Academic Mobility Regulation.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-32-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf'],
            ['id' => 'sub-mar-2024-acciones-internacionalizacion', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 33/2024 Ref.: Aprobar la implementación de acciones que fortalezcan la internacionalización.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 33/2024: Approval of actions to strengthen internationalization.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-33-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf'],
            ['id' => 'sub-mar-2024-indicadores-internacionalizacion', 'code' => 'SUB-MAR/2024', 'category' => 'primero', 'title' => ['es' => 'IV CONFERECIA NACIONAL ORDINARIA DE UNIVERSIDADES-RESOLUCIÓN N° 34/2024 Ref.: Aprobar la Incorporación de indicadores de internacionalización.', 'en' => '4th Ordinary National Conference of Universities - Resolution No. 34/2024: Approval of the incorporation of internationalization indicators.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/N.-34-IV-CONFERENCIA-NACIONAL-ORDINARIA-DE-UNIVERSIDADES-.pdf'],
            ['id' => 'umss-rcu-ago-2025-cudie', 'code' => 'UMSS_RCU-AGO/2025', 'category' => 'segundo', 'title' => ['es' => 'RCU N° 63/25 agosto, 2025. Ref.: Aprobar «REGLAMENTO COMISIÓN UNIVERSITARIA DE INTERNACIONALIZACIÓN EDUCATIVA (CUDIE) DE LA UMSS».', 'en' => 'RCU No. 63/25, August 2025: Approval of the UMSS University Commission for Educational Internationalization (CUDIE) Regulation.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/Reglamento-de-la-comision-CUDIE.pdf'],
            ['id' => 'umss-rcu-feb-2022-decipre', 'code' => 'UMSS_RCU-FEB/2022', 'category' => 'segundo', 'title' => ['es' => 'RCU N° 014/22 febrero, 2022. «DEPARTAMENTO DE COORDINACIÓN INTERINSTITUCIONAL PARA PROYECTOS REGIONALES (DECIPRE).»', 'en' => 'RCU No. 014/22, February 2022: Department of Interinstitutional Coordination for Regional Projects (DECIPRE).'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/10/DECIPRE.pdf'],
            ['id' => 'umss-rr-abr-2008-manual-convenios', 'code' => 'UMSS_RR-ABR/2008', 'category' => 'segundo', 'title' => ['es' => 'RR N° 115/08 abril, 2002. Ref.: Aprobar el «MANUAL DE PROCEDIMIENTOS PARA LA SUSCRIPCIÓN DE CONVENIOS».', 'en' => 'RR No. 115/08, April 2002: Approval of the Procedures Manual for Signing Agreements.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DE-PROCEDIMIENTOS-PARA-LA-SUSCRIPCION-DE-CONVENIOS.pdf'],
            ['id' => 'umss-rr-feb-2022-actualizacion-conocimiento', 'code' => 'UMSS_RR-FEB/2022', 'category' => 'segundo', 'title' => ['es' => 'RR N° 079/22 febrero, 2022. «DECIPRE CON DEPENDENCIA DIRECTA DE LA DRIC Y ACTUALIZACIÓN DEL CONOCIMIENTO».', 'en' => 'RR No. 079/22, February 2022: DECIPRE under direct DRIC authority and knowledge updating.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/10/Actualizacio%CC%81n-y-Conocimiento.pdf'],
            ['id' => 'umss-rr-feb-2023-mof-dric', 'code' => 'UMSS_RR-FEB/2023', 'category' => 'segundo', 'title' => ['es' => 'RR N° 161/23 febrero, 2023. MANUAL DE ORGANIZACIÓN Y FUNCIONES. Ref.: Aprobar el «MANUAL DE ORGANIZACIÓN Y FUNCIONES DRIC».', 'en' => 'RR No. 161/23, February 2023: Organization and Functions Manual. Approval of the DRIC Organization and Functions Manual.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DE-ORGANIZACION-Y-FUNCIONES-DRIC.pdf'],
            ['id' => 'umss-rr-feb-2023-manual-cargos-dric', 'code' => 'UMSS_RR-FEB/2023', 'category' => 'segundo', 'title' => ['es' => 'RR N° 161/23 febrero, 2023. MANUAL DE DESCRIPCIÓN DE CARGOS Ref.: Aprobar el «MANUAL DE DESCRIPCIÓN DE CARGOS DRIC».', 'en' => 'RR No. 161/23, February 2023: Position Description Manual. Approval of the DRIC Position Description Manual.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/09/MANUAL-DESCRIPCION-DE-CARGOS-DRIC-1.pdf'],
            ['id' => 'umss-rr-sep-2022-reglamento-especifico-dric', 'code' => 'UMSS_RR-SEP/2022', 'category' => 'segundo', 'title' => ['es' => 'RR N° 1017/22 septiembre, 2022. «REGLAMENTO ESPECÍFICO DE LA DIRECCIÓN DE RELACIONES INTERNACIONALES Y CONVENIOS»', 'en' => 'RR No. 1017/22, September 2022: Specific Regulation of the Office of International Relations and Agreements.'], 'downloadUrl' => 'https://dric.umss.edu.bo/wp-content/uploads/2025/10/Reglamento-Especifico-DRIC-sep.2022.pdf'],
        ];
    }

    private function section(Page $page, string $key, string $type, int $sortOrder, $languages, array $translations): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );

        foreach ($translations as $locale => $values) {
            SectionTranslation::updateOrCreate(['section_id' => $section->id, 'language_id' => $languages[$locale]->id], $values);
        }

        return $section;
    }
}
