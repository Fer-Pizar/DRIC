<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Section;
use App\Models\SectionTranslation;
use App\Support\PagePermissionMap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AgreementListContentController extends Controller
{
    private const GOVERNMENT_GROUPS = [
        'Convenios suscritos por el CEUB con otras instituciones' => 'Convenios suscritos por el CEUB con otras instituciones',
        'Alemania' => 'Alemania',
        'Argentina' => 'Argentina',
        'Austria' => 'Austria',
        'Belgica' => 'Bélgica',
        'Brasil' => 'Brasil',
        'Chile' => 'Chile',
        'China' => 'China',
        'Colombia' => 'Colombia',
        'Corea' => 'Corea',
        'Cuba' => 'Cuba',
        'Dinamarca' => 'Dinamarca',
        'Ecuador' => 'Ecuador',
        'EEUU' => 'EEUU',
        'Egipto' => 'Egipto',
        'España' => 'España',
        'Francia' => 'Francia',
        'Holanda' => 'Holanda',
        'Hungria' => 'Hungría',
        'India' => 'India',
        'Inglaterra' => 'Inglaterra',
        'Israel' => 'Israel',
        'Italia' => 'Italia',
        'Japón' => 'Japón',
        'Mexico' => 'México',
        'OEA' => 'OEA',
        'Panama' => 'Panamá',
        'Paraguay' => 'Paraguay',
        'Peru' => 'Perú',
        'Rusia' => 'Rusia',
        'Suecia' => 'Suecia',
        'Suiza' => 'Suiza',
        'Uruguay' => 'Uruguay',
        'Venezuela' => 'Venezuela',
        'Otras instituciones' => 'Otras instituciones',
    ];

    private const LISTS = [
        'otros' => [
            'page_slug' => 'convenios-otros',
            'section_key' => 'agreements.other.documents',
            'page_title_es' => 'Otros convenios suscritos',
            'page_title_en' => 'Other signed agreements',
            'section_title_es' => 'Documentos de otros convenios',
            'section_title_en' => 'Other agreement documents',
            'public_url' => '/es/convenios/otros',
        ],
        'ceub-gobierno' => [
            'page_slug' => 'convenios-ceub-gobierno',
            'section_key' => 'agreements.government.documents',
            'page_title_es' => 'Convenios CEUB y Gobierno de Bolivia',
            'page_title_en' => 'CEUB and Government of Bolivia Agreements',
            'section_title_es' => 'Documentos CEUB y Gobierno de Bolivia',
            'section_title_en' => 'CEUB and Government of Bolivia documents',
            'public_url' => '/es/convenios/ceub-gobierno',
        ],
    ];

    public function edit(string $list): View
    {
        $config = $this->config($list);
        $page = $this->ensurePage($config);
        $this->authorizeListAccess();

        $page->load([
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.agreement-list-content', [
            'list' => $list,
            'config' => $config,
            'agreementPage' => Page::query()->where('slug', 'convenios')->firstOrFail(),
            'documents' => $this->documents($page, $config),
            'governmentGroups' => self::GOVERNMENT_GROUPS,
        ]);
    }

    public function update(Request $request, string $list): RedirectResponse
    {
        $config = $this->config($list);
        $page = $this->ensurePage($config);
        $this->authorizeListAccess();

        $documents = $this->validatedDocuments($request);

        DB::transaction(function () use ($request, $page, $config, $documents): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $section = $this->ensureSection($page, $config, $languages);
            $keptIds = [];

            foreach ($documents as $sortOrder => $document) {
                $block = $document['id']
                    ? ContentBlock::query()
                        ->where('section_id', $section->id)
                        ->where('id', $document['id'])
                        ->first()
                    : null;

                if (! $block) {
                    $block = new ContentBlock([
                        'section_id' => $section->id,
                        'link_url' => $config['section_key'].'.'.Str::uuid()->toString(),
                    ]);
                }

                $block->fill([
                    'block_type' => 'agreement_document',
                    'sort_order' => $sortOrder + 1,
                    'is_active' => true,
                    'data' => array_filter([
                        'href' => $document['url'],
                        'country' => $document['country'] ?? null,
                    ], fn ($value) => filled($value)),
                ]);
                $block->save();
                $keptIds[] = $block->id;

                foreach (['es', 'en'] as $locale) {
                    ContentBlockTranslation::updateOrCreate(
                        ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                        [
                            'title' => $locale === 'es' ? $document['title_es'] : $document['title_en'],
                            'subtitle' => null,
                            'summary' => null,
                            'body' => null,
                        ]
                    );
                }
            }

            ContentBlock::query()
                ->where('section_id', $section->id)
                ->when($keptIds !== [], fn ($query) => $query->whereNotIn('id', $keptIds))
                ->delete();
        });

        return redirect()
            ->route('admin.agreement-lists.edit', $list)
            ->with('success', 'La lista de convenios fue actualizada correctamente.');
    }

    private function config(string $list): array
    {
        abort_unless(array_key_exists($list, self::LISTS), 404);

        return self::LISTS[$list];
    }

    private function ensurePage(array $config): Page
    {
        $parent = Page::query()->where('slug', 'convenios')->firstOrFail();
        $page = Page::updateOrCreate(
            ['slug' => $config['page_slug']],
            [
                'parent_id' => $parent->id,
                'page_type' => 'static',
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => $parent->sort_order,
            ]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach (['es', 'en'] as $locale) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $config["page_title_{$locale}"],
                    'menu_title' => $config["page_title_{$locale}"],
                    'subtitle' => null,
                    'summary' => null,
                    'body' => null,
                ]
            );
        }

        $this->ensureSection($page, $config, $languages);

        return $page;
    }

    private function ensureSection(Page $page, array $config, $languages): Section
    {
        $section = Section::firstOrNew(['page_id' => $page->id, 'section_key' => $config['section_key']]);
        $section->fill([
            'section_type' => 'agreement_document_list',
            'sort_order' => 1,
            'is_active' => true,
            'settings' => array_merge($section->settings ?? [], ['editable' => true]),
        ]);
        $section->save();

        foreach (['es', 'en'] as $locale) {
            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $config["section_title_{$locale}"],
                    'subtitle' => null,
                    'summary' => null,
                    'body' => null,
                ]
            );
        }

        return $section;
    }

    private function documents(Page $page, array $config): array
    {
        $section = $page->sections->firstWhere('section_key', $config['section_key']);
        $blocks = $section?->contentBlocks
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values() ?? collect();

        if ($blocks->isEmpty()) {
            return [];
        }

        return $blocks->map(fn (ContentBlock $block): array => [
            'id' => $block->id,
            'title_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
            'title_en' => $this->englishTitleFor(
                $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                $block->translations->firstWhere('language.code', 'en')?->title ?? ''
            ),
            'url' => is_string($block->data['href'] ?? null) ? $block->data['href'] : '',
            'country' => is_string($block->data['country'] ?? null)
                ? $block->data['country']
                : $this->inferGovernmentGroup(
                    $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                    $block->data ?? []
                ),
        ])->all();
    }

    private function validatedDocuments(Request $request): array
    {
        $rows = collect($request->input('documents', []))
            ->filter(fn ($row) => filled($row['title_es'] ?? null) || filled($row['title_en'] ?? null) || filled($row['url'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['documents' => $rows],
            [
                'documents' => ['array'],
                'documents.*.id' => ['nullable', 'integer'],
                'documents.*.country' => ['nullable', 'string', 'max:120'],
                'documents.*.country_custom' => ['nullable', 'string', 'max:120'],
                'documents.*.title_es' => ['required', 'string', 'max:600'],
                'documents.*.title_en' => ['nullable', 'string', 'max:600'],
                'documents.*.url' => ['required', 'url', 'max:900'],
            ],
            [
                'documents.*.title_es.required' => 'Escribe el título del documento.',
                'documents.*.country.max' => 'El país o grupo es demasiado largo. Usa máximo 120 caracteres.',
                'documents.*.country_custom.max' => 'El nuevo país es demasiado largo. Usa máximo 120 caracteres.',
                'documents.*.title_es.max' => 'El título es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.title_en.max' => 'El título en inglés es demasiado largo. Usa máximo 600 caracteres.',
                'documents.*.url.required' => 'Ingresa la URL del documento.',
                'documents.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf',
                'documents.*.url.max' => 'La URL es demasiado larga. Usa máximo 900 caracteres.',
            ]
        );

        $validated = $validator->validate();

        return collect($validated['documents'] ?? [])
            ->map(function ($row): array {
                $country = trim($row['country_custom'] ?? '') ?: trim($row['country'] ?? '');

                return [
                    'id' => isset($row['id']) ? (int) $row['id'] : null,
                    'title_es' => trim($row['title_es']),
                    'title_en' => $this->englishTitleFor(trim($row['title_es']), trim($row['title_en'] ?? '')),
                    'url' => trim($row['url']),
                    'country' => $country,
                ];
            })
            ->all();
    }

    private function englishTitleFor(string $spanishTitle, string $englishTitle): string
    {
        $englishTitle = trim($englishTitle);
        $spanishTitle = trim($spanishTitle);

        if ($englishTitle !== '' && $englishTitle !== $spanishTitle) {
            return $englishTitle;
        }

        return $this->translateGovernmentText($spanishTitle);
    }

    private function translateGovernmentText(string $text): string
    {
        $countryNames = [
            'Alemania' => 'Germany',
            'Argentina' => 'Argentina',
            'Austria' => 'Austria',
            'Belgica' => 'Belgium',
            'Brasil' => 'Brazil',
            'Chile' => 'Chile',
            'China' => 'China',
            'Colombia' => 'Colombia',
            'Corea' => 'South Korea',
            'Cuba' => 'Cuba',
            'Dinamarca' => 'Denmark',
            'Ecuador' => 'Ecuador',
            'EEUU' => 'United States',
            'Egipto' => 'Egypt',
            'España' => 'Spain',
            'Francia' => 'France',
            'Holanda' => 'Netherlands',
            'Hungria' => 'Hungary',
            'India' => 'India',
            'Inglaterra' => 'United Kingdom',
            'Israel' => 'Israel',
            'Italia' => 'Italy',
            'Japón' => 'Japan',
            'Mexico' => 'Mexico',
            'OEA' => 'OAS',
            'Panama' => 'Panama',
            'Paraguay' => 'Paraguay',
            'Peru' => 'Peru',
            'Rusia' => 'Russia',
            'Suecia' => 'Sweden',
            'Suiza' => 'Switzerland',
            'Uruguay' => 'Uruguay',
            'Venezuela' => 'Venezuela',
        ];

        if (array_key_exists($text, $countryNames)) {
            return $countryNames[$text];
        }

        $phrases = [
            '/Convenios suscritos por el CEUB con otras instituciones/i' => 'Agreements signed by CEUB with other institutions',
            '/Convenio Marco Interinstitucional de cooperación académica, científica y administrativa/i' => 'Interinstitutional Framework Agreement for academic, scientific, and administrative cooperation',
            '/Convenio Marco de Cooperación Interinstitucional/i' => 'Framework Agreement for Interinstitutional Cooperation',
            '/Convenio marco de cooperación interinstitucional/i' => 'Framework Agreement for Interinstitutional Cooperation',
            '/Convenio marco cooperación insterinstitucional/i' => 'Framework Agreement for Interinstitutional Cooperation',
            '/Convenio Marco de Colaboración Interinstitucional/i' => 'Framework Agreement for Interinstitutional Collaboration',
            '/Convenio marco de colaboración interinstitucional/i' => 'Framework Agreement for Interinstitutional Collaboration',
            '/Convenio marco de colaboración académica, científica y cultural/i' => 'Framework Agreement for academic, scientific, and cultural collaboration',
            '/Convenio marco de colaboración académica/i' => 'Framework Agreement for academic collaboration',
            '/Convenio de Cooperación Interinstitucional/i' => 'Interinstitutional Cooperation Agreement',
            '/Convenio de cooperación interinstitucional/i' => 'Interinstitutional Cooperation Agreement',
            '/Convenio de cooperación Interinstitucional/i' => 'Interinstitutional Cooperation Agreement',
            '/Convenio básico de cooperación técnica y científica/i' => 'Basic Agreement on technical and scientific cooperation',
            '/Convenio de cooperación cultural, científica y técnica/i' => 'Agreement on cultural, scientific, and technical cooperation',
            '/Convenio de Cooperación Técnica y Científica/i' => 'Agreement on technical and scientific cooperation',
            '/Convenio de cooperación Técnica y Científica/i' => 'Agreement on technical and scientific cooperation',
            '/Convenio de Cooperación Cultural/i' => 'Cultural Cooperation Agreement',
            '/Convenio de cooperación cultural/i' => 'Cultural Cooperation Agreement',
            '/Convenio Cultural/i' => 'Cultural Agreement',
            '/Convenio de cooperación turística/i' => 'Tourism Cooperation Agreement',
            '/Acuerdo de Cooperación Turística/i' => 'Tourism Cooperation Agreement',
            '/Acuerdo de cooperación turística/i' => 'Tourism Cooperation Agreement',
            '/Acuerdo de Cooperación Cultural/i' => 'Cultural Cooperation Agreement',
            '/Acuerdo de cooperación en materia de turismo/i' => 'Agreement on tourism cooperation',
            '/Acuerdo de Cooperación Técnica, Científica y de Asistencia Humanitaria/i' => 'Agreement on technical, scientific, and humanitarian assistance cooperation',
            '/Acuerdo de Cooperación en Ciencia y Tecnología/i' => 'Agreement on Science and Technology Cooperation',
            '/Acuerdo básico de Cooperación Técnica y Científica/i' => 'Basic Agreement on Technical and Scientific Cooperation',
            '/Acuerdo básico de cooperación técnica, científica y tecnológica/i' => 'Basic Agreement on technical, scientific, and technological cooperation',
            '/Acuerdo de Cooperación Científica y Tecnológica/i' => 'Agreement on Scientific and Technological Cooperation',
            '/Acuerdo de Cooperación Científico-Tecnica y Tecnológica/i' => 'Agreement on Scientific, Technical, and Technological Cooperation',
            '/Acuerdo Cultural/i' => 'Cultural Agreement',
            '/Acuerdo Básico de Cooperación/i' => 'Basic Cooperation Agreement',
            '/Acuerdo de Asistencia Técnica/i' => 'Technical Assistance Agreement',
            '/Acuerdo de cooperación/i' => 'Cooperation Agreement',
            '/Memorándum de entendimiento/i' => 'Memorandum of Understanding',
            '/Memorandum de Entendimiento/i' => 'Memorandum of Understanding',
            '/Memorandum de entendimiento/i' => 'Memorandum of Understanding',
            '/Memorandúm de Entendimiento/i' => 'Memorandum of Understanding',
            '/Protocolo de Intenciones/i' => 'Protocol of Intentions',
            '/Acta de canje de instrumentos de ratificación/i' => 'Exchange of instruments of ratification record',
            '/Acta de Canje/i' => 'Exchange record',
            '/Ley Nº/i' => 'Law No.',
            '/Ley /i' => 'Law ',
            '/D\.S\./i' => 'Supreme Decree',
            '/República de Bolivia/i' => 'Republic of Bolivia',
            '/Estado Plurinacional de Bolivia/i' => 'Plurinational State of Bolivia',
            '/Gobierno de Bolivia/i' => 'Government of Bolivia',
            '/Gobierno de la República de Bolivia/i' => 'Government of the Republic of Bolivia',
            '/Gobierno dela República de Bolivia/i' => 'Government of the Republic of Bolivia',
            '/Gobierno del Estado Plurinacional de Bolivia/i' => 'Government of the Plurinational State of Bolivia',
            '/Gobierno Autónomo/i' => 'Autonomous Government',
            '/Comité Ejecutivo de la Universidad Boliviana/i' => 'Executive Committee of the Bolivian University',
            '/Universidad Boliviana/i' => 'Bolivian University',
            '/Universidad Nacional/i' => 'National University',
            '/Universidades Españolas/i' => 'Spanish Universities',
            '/Ministerio de Desarrollo Productivo y Economía Plural/i' => 'Ministry of Productive Development and Plural Economy',
            '/Ministerio de Justicia y Transparencia Institucional/i' => 'Ministry of Justice and Institutional Transparency',
            '/Ministerio de Economía y Finanzas Públicas/i' => 'Ministry of Economy and Public Finance',
            '/Ministerio de la Presidencia/i' => 'Ministry of the Presidency',
            '/Ministerio de Obras Públicas Servicios y Vivienda/i' => 'Ministry of Public Works, Services, and Housing',
            '/Ministerio de Obras Públicas, Servicios y Vivienda/i' => 'Ministry of Public Works, Services, and Housing',
            '/Ministerio de Educación/i' => 'Ministry of Education',
            '/Ministerio de Culturas/i' => 'Ministry of Cultures',
            '/Tribunal Supremo de Justicia/i' => 'Supreme Court of Justice',
            '/Tribunal Constitucional Plurinacional/i' => 'Plurinational Constitutional Court',
            '/Tribunal Agroambiental/i' => 'Agro-Environmental Court',
            '/Consejo de la Magistratura/i' => 'Council of the Magistracy',
            '/Dirección del Notariado Plurinacional/i' => 'Plurinational Notary Directorate',
            '/Dirección Administrativa y Financiera del Órgano Judicial/i' => 'Administrative and Financial Directorate of the Judicial Branch',
            '/Escuela de Jueces del Estado/i' => 'State Judges School',
            '/Agencia Nacional de Hidrocarburos/i' => 'National Hydrocarbons Agency',
            '/Agencia Boliviana Espacial/i' => 'Bolivian Space Agency',
            '/Fondo de Desarrollo Indígena/i' => 'Indigenous Development Fund',
            '/Yacimientos Petrolíferos Fiscales Bolivianos/i' => 'Bolivian Fiscal Oilfields',
            '/Conferencia de Presidentes de Universidad/i' => 'Conference of University Presidents',
            '/Conferencia de Directores de las Escuelas Francesas de Ingenieros/i' => 'Conference of Directors of French Engineering Schools',
            '/conferencia de rectores/i' => 'conference of rectors',
            '/Cooperativa de Ahorro y Crédito de Vinculo Laboral/i' => 'Employment-Based Savings and Credit Cooperative',
            '/Universidad de Tecnología de Graz/i' => 'Graz University of Technology',
            '/Universidad Federal del Acre/i' => 'Federal University of Acre',
            '/Instituto Federal de Educación, Ciencia e Tecnología do ACRE/i' => 'Federal Institute of Education, Science and Technology of Acre',
            '/Universidad Nacional Amazónica de Madre de Dios/i' => 'National Amazonian University of Madre de Dios',
            '/República Federal de Alemania/i' => 'Federal Republic of Germany',
            '/República Argentina/i' => 'Argentine Republic',
            '/República Federativa del Brasil/i' => 'Federative Republic of Brazil',
            '/República Popular China/i' => "People's Republic of China",
            '/República de Colombia/i' => 'Republic of Colombia',
            '/República de Corea/i' => 'Republic of Korea',
            '/República de Cuba/i' => 'Republic of Cuba',
            '/Reino de Dinamarca/i' => 'Kingdom of Denmark',
            '/República del Ecuador/i' => 'Republic of Ecuador',
            '/Estados Unidos de América/i' => 'United States of America',
            '/República Árabe de Egipto/i' => 'Arab Republic of Egypt',
            '/República de Francia/i' => 'French Republic',
            '/República Popular de Hungría/i' => "People's Republic of Hungary",
            '/República de la India/i' => 'Republic of India',
            '/Consejo Británico/i' => 'British Council',
            '/Estado de Israel/i' => 'State of Israel',
            '/República Italiana/i' => 'Italian Republic',
            '/Estados Unidos Mexicanos/i' => 'United Mexican States',
            '/República de Panamá/i' => 'Republic of Panama',
            '/República de Paraguay/i' => 'Republic of Paraguay',
            '/República del Paraguay/i' => 'Republic of Paraguay',
            '/República del Perú/i' => 'Republic of Peru',
            '/Federación de Rusia/i' => 'Russian Federation',
            '/Confederación Suiza/i' => 'Swiss Confederation',
            '/República Oriental del Uruguay/i' => 'Oriental Republic of Uruguay',
            '/República Bolivariana de Venezuela/i' => 'Bolivarian Republic of Venezuela',
            '/aprobado y ratificado/i' => 'approved and ratified',
            '/Aprobado y ratificado/i' => 'Approved and ratified',
            '/Aprobado/i' => 'Approved',
            '/Ratificado/i' => 'Ratified',
            '/ratificando/i' => 'ratifying',
            '/aprueba y ratifica/i' => 'approves and ratifies',
            '/aprueba/i' => 'approves',
            '/suscrito entre/i' => 'signed between',
            '/celebrado entre/i' => 'entered into between',
            '/entre/i' => 'between',
            '/ y /i' => ' and ',
            '/para/i' => 'for',
            '/sobre/i' => 'on',
            '/en materia de/i' => 'in the area of',
            '/en el área de/i' => 'in the area of',
            '/en las áreas de/i' => 'in the areas of',
            '/en apoyo a/i' => 'in support of',
            '/la cooperación/i' => 'cooperation',
            '/cooperación/i' => 'cooperation',
            '/colaboración/i' => 'collaboration',
            '/interinstitucional/i' => 'interinstitutional',
            '/académica/i' => 'academic',
            '/científica/i' => 'scientific',
            '/técnica/i' => 'technical',
            '/tecnológica/i' => 'technological',
            '/cultural/i' => 'cultural',
            '/educativa/i' => 'educational',
            '/turismo/i' => 'tourism',
            '/educación superior/i' => 'higher education',
            '/reconocimiento/i' => 'recognition',
            '/títulos/i' => 'degrees',
            '/diplomas/i' => 'diplomas',
            '/certificados académicos/i' => 'academic certificates',
            '/estudios parciales/i' => 'partial studies',
            '/recuperación de bienes culturales/i' => 'recovery of cultural property',
            '/robados, importados o exportados ilícitamente/i' => 'stolen, imported, or exported illicitly',
            '/intercambio/i' => 'exchange',
            '/profesores/i' => 'professors',
            '/estudiantes/i' => 'students',
            '/viajes/i' => 'travel',
            '/deporte/i' => 'sports',
            '/salud/i' => 'health',
            '/ciencia/i' => 'science',
            '/Propiedad Intelectual/i' => 'Intellectual Property',
            '/Ejecutivo/i' => 'Executive',
            '/Ejectivo/i' => 'Executive',
            '/Dirección/i' => 'Directorate',
            '/Administrativa/i' => 'Administrative',
            '/Financiera/i' => 'Financial',
            '/Órgano Judicial/i' => 'Judicial Branch',
            '/Estado/i' => 'State',
            '/Ahorro/i' => 'Savings',
            '/Crédito/i' => 'Credit',
            '/Vinculo Laboral/i' => 'Employment-Based',
            '/Universidad/i' => 'University',
            '/Instituto/i' => 'Institute',
            '/Federal/i' => 'Federal',
            '/Educación/i' => 'Education',
            '/Economía/i' => 'Economy',
            '/Plural/i' => 'Plural',
            '/Desarrollo Productivo/i' => 'Productive Development',
            '/Justicia/i' => 'Justice',
            '/Transparencia Institucional/i' => 'Institutional Transparency',
        ];

        $translated = $text;

        foreach ($phrases as $pattern => $replacement) {
            $translated = preg_replace($pattern, $replacement, $translated) ?? $translated;
        }

        return trim(preg_replace('/\s+/', ' ', $translated) ?? $translated);
    }

    private function inferGovernmentGroup(string $title, array $data): string
    {
        $explicit = collect(['country', 'country_name', 'section', 'category', 'group'])
            ->map(fn (string $key) => $data[$key] ?? null)
            ->first(fn ($value) => is_string($value) && trim($value) !== '');

        if (is_string($explicit)) {
            return trim($explicit);
        }

        $normalized = Str::lower(Str::ascii($title));

        if (str_contains($normalized, 'ceub') || str_contains($normalized, 'comite ejecutivo') || str_contains($normalized, 'universidad boliviana')) {
            return 'Convenios suscritos por el CEUB con otras instituciones';
        }

        foreach (array_keys(self::GOVERNMENT_GROUPS) as $group) {
            if ($group === 'Convenios suscritos por el CEUB con otras instituciones' || $group === 'Otras instituciones') {
                continue;
            }

            if (str_contains($normalized, Str::lower(Str::ascii($group)))) {
                return $group;
            }
        }

        return 'Otras instituciones';
    }

    private function authorizeListAccess(): void
    {
        $agreementPage = Page::query()->where('slug', 'convenios')->firstOrFail();

        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $agreementPage), 403, 'No tienes permiso para editar Convenios.');
    }
}
