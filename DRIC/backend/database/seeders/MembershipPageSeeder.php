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

class MembershipPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::where('slug', 'membresias')->firstOrFail();
        $page->update(['status' => 'published', 'published_at' => $page->published_at ?? now()]);

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(['page_id' => $page->id, 'language_id' => $languages[$locale]->id], $values);
        }

        $this->section($page, 'memberships.hero', 'memberships_hero', 1, $languages, [
            'es' => ['title' => 'Membresías', 'subtitle' => 'DRIC · UMSS', 'summary' => 'La Universidad Mayor de San Simón participa en redes, asociaciones y programas internacionales que fortalecen la cooperación académica, científica e institucional.', 'body' => null],
            'en' => ['title' => 'Memberships', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Universidad Mayor de San Simón participates in international networks, associations and programs that strengthen academic, scientific and institutional cooperation.', 'body' => null],
        ]);

        $list = $this->section($page, 'memberships.list', 'membership_list', 2, $languages, [
            'es' => ['title' => 'Alianzas que conectan a la UMSS con el mundo', 'subtitle' => 'Redes internacionales', 'summary' => null, 'body' => null],
            'en' => ['title' => 'Partnerships connecting UMSS with the world', 'subtitle' => 'International networks', 'summary' => null, 'body' => null],
        ]);

        $this->section($page, 'memberships.info', 'memberships_info', 3, $languages, [
            'es' => ['title' => 'Información institucional', 'subtitle' => null, 'summary' => 'Para mayor información sobre registros, membresías institucionales o participación en redes internacionales, contactar con la Dirección de Relaciones Internacionales y Convenios.', 'body' => null],
            'en' => ['title' => 'Institutional information', 'subtitle' => null, 'summary' => 'For more information about institutional records, memberships or participation in international networks, contact the Directorate of International Relations and Agreements.', 'body' => null],
        ]);

        if (! ContentBlock::query()->where('section_id', $list->id)->exists()) {
            foreach ($this->memberships() as $index => $membership) {
                $block = ContentBlock::create([
                    'section_id' => $list->id,
                    'block_type' => 'membership_item',
                    'link_url' => 'memberships.item.'.Str::uuid()->toString(),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'data' => [
                        'url' => $membership['url'],
                        'logo' => $membership['logo'],
                        'extra_info_enabled' => (bool) ($membership['extra_info_enabled'] ?? false),
                        'extra_info_email' => $membership['extra_info_email'] ?? '',
                    ],
                ]);

                foreach (['es', 'en'] as $locale) {
                    ContentBlockTranslation::updateOrCreate(
                        ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                        [
                            'title' => $membership["title_{$locale}"],
                            'subtitle' => null,
                            'summary' => $membership["description_{$locale}"],
                            'body' => $membership["pador_text_{$locale}"] ?? null,
                        ]
                    );
                }
            }
        }
    }

    private function pageTranslations(): array
    {
        return [
            'es' => ['title' => 'Membresías', 'menu_title' => 'Membresías', 'subtitle' => 'DRIC · UMSS', 'summary' => 'La Universidad Mayor de San Simón participa en redes, asociaciones y programas internacionales que fortalecen la cooperación académica, científica e institucional.', 'body' => null],
            'en' => ['title' => 'Memberships', 'menu_title' => 'Memberships', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Universidad Mayor de San Simón participates in international networks, associations and programs that strengthen academic, scientific and institutional cooperation.', 'body' => null],
        ];
    }

    private function memberships(): array
    {
        return [
            ['title_es' => 'AUF', 'title_en' => 'AUF', 'description_es' => 'Agencia Universitaria de la Francofonía', 'description_en' => 'University Agency of La Francophonie', 'url' => 'https://www.auf.org/', 'logo' => '/images/memberships/auf.png'],
            ['title_es' => 'AUGM', 'title_en' => 'AUGM', 'description_es' => 'Asociación de Universidades Grupo Montevideo', 'description_en' => 'Association of Universities of the Montevideo Group', 'url' => 'https://grupomontevideo.org/', 'logo' => '/images/memberships/augm.png'],
            ['title_es' => 'UNAI', 'title_en' => 'UNAI', 'description_es' => 'Impacto Académico de las Naciones Unidas', 'description_en' => 'United Nations Academic Impact', 'url' => 'https://www.un.org/es/academicimpact', 'logo' => '/images/memberships/unai.png'],
            ['title_es' => 'AUIP', 'title_en' => 'AUIP', 'description_es' => 'Asociación Universitaria Iberoamericana de Posgrado', 'description_en' => 'Ibero-American Postgraduate University Association', 'url' => 'https://auip.org/', 'logo' => '/images/memberships/auip.png'],
            ['title_es' => 'CRISCOS', 'title_en' => 'CRISCOS', 'description_es' => 'Consejo de Rectores por la Integración de la Subregión Centro Oeste de Sudamérica', 'description_en' => 'Council of Rectors for the Integration of the Central-Western South American Subregion', 'url' => 'https://criscos.unju.edu.ar/', 'logo' => '/images/memberships/criscos.png'],
            ['title_es' => 'CLACSO', 'title_en' => 'CLACSO', 'description_es' => 'Consejo Latinoamericano de Ciencias Sociales', 'description_en' => 'Latin American Council of Social Sciences', 'url' => 'https://www.clacso.org/', 'logo' => '/images/memberships/clacso.png'],
            ['title_es' => 'UNAMAZ', 'title_en' => 'UNAMAZ', 'description_es' => 'Asociación de Universidades Amazónicas', 'description_en' => 'Association of Amazonian Universities', 'url' => 'https://www.unamaz.org/es', 'logo' => '/images/memberships/unamaz.png'],
            ['title_es' => 'PADOR', 'title_en' => 'PADOR', 'description_es' => 'Servicios de Registro en Línea de Ayuda Europea', 'description_en' => 'European Aid Online Registration Services', 'url' => '', 'logo' => '/images/memberships/pador.png', 'extra_info_enabled' => true, 'extra_info_email' => 'dric@umss.edu', 'pador_text_es' => 'Para mayor información sobre el registro PADOR, contactar a:', 'pador_text_en' => 'For more information about PADOR registration, contact:'],
            ['title_es' => 'Comisión Europea', 'title_en' => 'European Commission', 'description_es' => 'Programas y cooperación internacional de la Unión Europea', 'description_en' => 'European Union international cooperation and programs', 'url' => 'https://commission.europa.eu/index_es', 'logo' => '/images/memberships/comision-europea.png'],
            ['title_es' => 'Universia', 'title_en' => 'Universia', 'description_es' => 'Plataforma iberoamericana que conecta universidades, estudiantes, instituciones y oportunidades académicas internacionales.', 'description_en' => 'Ibero-American platform connecting universities, students, institutions and international academic opportunities.', 'url' => 'https://www.universia.net/', 'logo' => '/images/memberships/universia.png'],
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
