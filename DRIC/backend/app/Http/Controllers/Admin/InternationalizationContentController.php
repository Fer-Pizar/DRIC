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
use Illuminate\View\View;

class InternationalizationContentController extends Controller
{
    private const CARDS = [1, 2, 3];

    public function edit(Page $page): View
    {
        $this->authorizeInternationalizationAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.internationalization-content', [
            'page' => $page,
            'content' => $this->formContent($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeInternationalizationAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();

        DB::transaction(function () use ($request, $validated, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

            $hero = $this->upsertSection($page, 'internationalization.hero', 'internationalization_hero', 1);
            $detail = $this->upsertSection($page, 'internationalization.detail', 'internationalization_detail', 2);
            $workAreas = $this->upsertSection($page, 'internationalization.work_areas', 'internationalization_work_areas', 3);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['eyebrow'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $detail->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['detail_title'],
                        'subtitle' => null,
                        'summary' => null,
                        'body' => $validated[$locale]['detail_text'],
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $workAreas->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['section_title'],
                        'subtitle' => $validated[$locale]['section_eyebrow'],
                        'summary' => $validated[$locale]['section_text'],
                        'body' => null,
                    ]
                );
            }

            foreach (self::CARDS as $index) {
                $this->upsertBlock(
                    $workAreas,
                    "internationalization.card.{$index}",
                    'internationalization_card',
                    $index,
                    $languages,
                    [
                        'es' => [
                            'title' => $validated['cards'][$index]['title_es'],
                            'summary' => $validated['cards'][$index]['text_es'],
                        ],
                        'en' => [
                            'title' => $validated['cards'][$index]['title_en'],
                            'summary' => $validated['cards'][$index]['text_en'],
                        ],
                    ],
                    ['icon' => $this->cardIcon($index)]
                );
            }
        });

        return redirect()
            ->route('admin.pages.internationalization.edit', $page)
            ->with('success', 'El contenido de Internacionalización fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.eyebrow"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:1200'];
            $rules["{$locale}.detail_title"] = ['required', 'string', 'max:180'];
            $rules["{$locale}.detail_text"] = ['required', 'string', 'max:6000'];
            $rules["{$locale}.section_eyebrow"] = ['required', 'string', 'max:140'];
            $rules["{$locale}.section_title"] = ['required', 'string', 'max:220'];
            $rules["{$locale}.section_text"] = ['required', 'string', 'max:1200'];
        }

        foreach (self::CARDS as $index) {
            $rules["cards.{$index}.title_es"] = ['required', 'string', 'max:180'];
            $rules["cards.{$index}.title_en"] = ['required', 'string', 'max:180'];
            $rules["cards.{$index}.text_es"] = ['required', 'string', 'max:900'];
            $rules["cards.{$index}.text_en"] = ['required', 'string', 'max:900'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera la extensión permitida.',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'eyebrow' => $this->sectionValue($page, 'internationalization.hero', 'es', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'es', 'title', 'Internacionalización'),
                'intro' => $this->sectionValue($page, 'internationalization.hero', 'es', 'summary', 'La internacionalización fortalece la formación académica, la cooperación científica y la vinculación institucional de la Universidad Mayor de San Simón con redes, universidades y organismos del mundo.'),
                'detail_title' => $this->sectionValue($page, 'internationalization.detail', 'es', 'title', 'Internacionalización'),
                'detail_text' => $this->sectionValue($page, 'internationalization.detail', 'es', 'body', implode("\n\n", $this->detailParagraphs('es'))),
                'section_eyebrow' => $this->sectionValue($page, 'internationalization.work_areas', 'es', 'subtitle', 'Ejes de trabajo'),
                'section_title' => $this->sectionValue($page, 'internationalization.work_areas', 'es', 'title', 'Una universidad conectada con oportunidades globales'),
                'section_text' => $this->sectionValue($page, 'internationalization.work_areas', 'es', 'summary', 'Este espacio reúne las líneas de acción que impulsan la presencia internacional de la UMSS y facilitan nuevas oportunidades para estudiantes, docentes, investigadores y unidades académicas.'),
            ],
            'en' => [
                'eyebrow' => $this->sectionValue($page, 'internationalization.hero', 'en', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'en', 'title', 'Internationalization'),
                'intro' => $this->sectionValue($page, 'internationalization.hero', 'en', 'summary', 'Internationalization strengthens academic training, scientific cooperation and institutional engagement between Universidad Mayor de San Simón and global networks, universities and organizations.'),
                'detail_title' => $this->sectionValue($page, 'internationalization.detail', 'en', 'title', 'Internationalization'),
                'detail_text' => $this->sectionValue($page, 'internationalization.detail', 'en', 'body', implode("\n\n", $this->detailParagraphs('en'))),
                'section_eyebrow' => $this->sectionValue($page, 'internationalization.work_areas', 'en', 'subtitle', 'Work areas'),
                'section_title' => $this->sectionValue($page, 'internationalization.work_areas', 'en', 'title', 'A university connected to global opportunities'),
                'section_text' => $this->sectionValue($page, 'internationalization.work_areas', 'en', 'summary', 'This space brings together the lines of action that expand UMSS international presence and create new opportunities for students, faculty, researchers and academic units.'),
            ],
            'cards' => $this->cards($page),
        ];
    }

    private function cards(Page $page): array
    {
        $fallbacks = [
            1 => ['title_es' => 'Cooperación académica', 'title_en' => 'Academic cooperation', 'text_es' => 'Promovemos vínculos con instituciones nacionales e internacionales para fortalecer proyectos, redes y programas conjuntos.', 'text_en' => 'We promote relationships with national and international institutions to strengthen projects, networks and joint programs.'],
            2 => ['title_es' => 'Movilidad y formación', 'title_en' => 'Mobility and training', 'text_es' => 'Impulsamos oportunidades de intercambio, becas, pasantías y experiencias internacionales para la comunidad universitaria.', 'text_en' => 'We support exchange opportunities, scholarships, internships and international experiences for the university community.'],
            3 => ['title_es' => 'Proyección institucional', 'title_en' => 'Institutional projection', 'text_es' => 'Acompañamos la participación de la UMSS en espacios globales de colaboración, innovación y desarrollo académico.', 'text_en' => 'We accompany UMSS participation in global spaces for collaboration, innovation and academic development.'],
        ];

        foreach (self::CARDS as $index) {
            $fallbacks[$index]['title_es'] = $this->blockValue($page, "internationalization.card.{$index}", 'es', 'title', $fallbacks[$index]['title_es']);
            $fallbacks[$index]['title_en'] = $this->blockValue($page, "internationalization.card.{$index}", 'en', 'title', $fallbacks[$index]['title_en']);
            $fallbacks[$index]['text_es'] = $this->blockValue($page, "internationalization.card.{$index}", 'es', 'summary', $fallbacks[$index]['text_es']);
            $fallbacks[$index]['text_en'] = $this->blockValue($page, "internationalization.card.{$index}", 'en', 'summary', $fallbacks[$index]['text_en']);
        }

        return $fallbacks;
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): ContentBlock
    {
        $block = ContentBlock::updateOrCreate(
            ['section_id' => $section->id, 'link_url' => $key],
            ['block_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'data' => $data]
        );

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'] ?? null,
                    'subtitle' => null,
                    'summary' => $translations[$locale]['summary'] ?? null,
                    'body' => null,
                    'cta_label' => null,
                ]
            );
        }

        return $block;
    }

    private function block(Page $page, string $key): ?ContentBlock
    {
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key);
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $this->block($page, $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function detailParagraphs(string $locale): array
    {
        return [
            'es' => [
                'La Internacionalización de la Educación Superior tiene como propósito mejorar los procesos de formación, investigación e interacción social en las universidades, contribuyendo de esta manera a la sociedad con profesionales/ciudadanos preparados para enfrentar los cambios y desafíos, a escala no solo Local sino también Regional y Mundial.',
                'Se cuenta con una propuesta de un Plan de Internacionalización que tiene como objetivo: Fortalecer los procesos y acciones de internacionalización que se desarrollan en la UMSS, desde una perspectiva endógena, colaborativa, integral e interregional, propiciando su incorporación institucional, transversal y contextualizada en las funciones formativas, investigativas y de interrelación y servicio a la comunidad; con políticas, estrategias y acciones sistematizadas en un Plan de Internacionalización Universitario concertado y amplio y, que responda a la nueva realidad generada como efecto de la pandemia en nuestro país y en el planeta.',
                'Actualmente la Dirección de Relaciones Internacionales y Convenios, tiene el objetivo de generar un proceso de apropiación del indicado Plan de parte de la comunidad sansimoniana, de manera que se consiga su fortalecimiento a través de la definición de políticas y estrategias institucionales.',
                'En el contexto generado por la pandemia del covid-19, las instituciones de Educación Superior debemos trabajar en transformaciones y cambios reales que mejoren la calidad de la formación para responder a nuestro encargo social. La Internacionalización es un instrumento que posibilita encaminarnos hacia la calidad en la formación de competencias para el desempeño de los profesionales en todos los ámbitos del planeta.',
                'Se plantea como una necesidad el implementar programas y estrategias apoyadas en el uso de la conectividad digital, para el desarrollo de la internacionalización en casa, la movilidad virtual, la investigación conjunta con socios de la Región y del mundo, el desarrollo de proyectos conjuntos, el intercambio de conocimientos y experiencias en redes, eventos colaborativos entre universidades y países, entre otras acciones.',
            ],
            'en' => [
                'The internationalization of higher education aims to improve training, research, and social interaction processes in universities, contributing to society with professionals and citizens prepared to face changes and challenges at local, regional, and global scales.',
                'There is a proposal for an Internationalization Plan whose objective is to strengthen the internationalization processes and actions developed at UMSS from an endogenous, collaborative, comprehensive, and interregional perspective, promoting their institutional, cross-cutting, and contextualized incorporation into training, research, interrelation, and community service functions.',
                'Currently, the Directorate of International Relations and Agreements seeks to generate a process through which the San Simon community takes ownership of this Plan, so it can be strengthened through the definition of institutional policies and strategies.',
                'In the context generated by the covid-19 pandemic, higher education institutions must work on real transformations and changes that improve the quality of education in response to our social mission. Internationalization is an instrument that allows us to move toward quality in the development of competencies for professional performance in every sphere of the world.',
                'It is necessary to implement programs and strategies supported by digital connectivity for the development of internationalization at home, virtual mobility, joint research with partners in the region and around the world, joint projects, knowledge and experience exchange through networks, and collaborative events between universities and countries, among other actions.',
            ],
        ][$locale] ?? [];
    }

    private function cardIcon(int $index): string
    {
        return [1 => 'public', 2 => 'school', 3 => 'groups'][$index] ?? 'public';
    }

    private function authorizeInternationalizationAccess(Page $page): void
    {
        abort_unless($page->slug === 'internacionalizacion', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
