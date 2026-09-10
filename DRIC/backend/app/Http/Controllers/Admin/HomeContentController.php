<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\ContentBlockTranslation;
use App\Models\Language;
use App\Models\MediaAsset;
use App\Models\MediaTranslation;
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

class HomeContentController extends Controller
{
    private const MAX_IMAGE_KB = 5120;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';
    private const COUNTRIES = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    private const AGREEMENTS = [1, 2, 3];
    private const DIRECTOR_BLOCKS = [1, 2];
    private const STATS = [1, 2, 3];

    public function edit(Page $page): View
    {
        $this->authorizeHomeAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.home-content', [
            'page' => $page,
            'content' => $this->formContent($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeHomeAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $faqs = $this->validatedFaqs($request);

        DB::transaction(function () use ($request, $validated, $faqs, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

            $hero = $this->upsertSection($page, 'home.hero', 'hero', 1, [
                'theme' => 'dark',
                'background' => '/images/hero/hero-blur-bg.jpg',
                'layout' => 'centered',
            ]);
            $scholarships = $this->upsertSection($page, 'home.scholarships', 'scholarship_country_grid', 2, [
                'theme' => 'dark',
                'layout' => 'masonry-grid',
            ]);
            $about = $this->upsertSection($page, 'home.about', 'about_dric', 3, $this->mergedSettings($page, 'home.about', [
                'theme' => 'dark',
                'layout' => 'text-image',
                'image' => '/images/administration/dric-team.jpg',
            ]));
            $recentAgreements = $this->upsertSection($page, 'home.recent_agreements', 'recent_agreements', 4, [
                'theme' => 'dark',
                'layout' => 'three-card-grid',
            ]);
            $director = $this->upsertSection($page, 'home.director', 'director_mission_purpose', 5, [
                'theme' => 'dark',
                'layout' => 'director-card',
                'image' => '/images/administration/director.jpg',
            ]);
            $stats = $this->upsertSection($page, 'home.stats', 'stats', 6, [
                'theme' => 'blue-glow',
                'layout' => 'three-columns',
            ]);
            $testimonials = $this->upsertSection($page, 'home.student_testimonials', 'student_testimonials', 7, [
                'theme' => 'dark',
                'layout' => 'student-carousel',
                'image' => '/images/home/student-experience.png',
            ]);
            $faq = $this->upsertSection($page, 'home.faq', 'faq', 8, $this->mergedSettings($page, 'home.faq', [
                'theme' => 'dark-blue',
                'layout' => 'image-accordion',
                'image' => '/images/testimonials/students-faq.jpg',
            ]));
            $finalCta = $this->upsertSection($page, 'home.final_cta', 'final_cta', 9, [
                'theme' => 'dark-blur',
                'background' => '/images/hero/hero-blur-bg.jpg',
                'layout' => 'centered-cta',
            ]);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['page_title'],
                        'menu_title' => $validated[$locale]['page_title'],
                        'subtitle' => $validated[$locale]['hero_title'],
                        'summary' => $validated[$locale]['hero_summary'],
                        'body' => null,
                    ]
                );

                $this->translateSection($hero, $languages[$locale], $validated[$locale]['hero_title'], $validated[$locale]['hero_badge'], $validated[$locale]['hero_summary']);
                $this->translateSection($scholarships, $languages[$locale], $validated[$locale]['scholarships_title'], $validated[$locale]['scholarships_subtitle'], $validated[$locale]['scholarships_summary']);
                $this->translateSection($about, $languages[$locale], $validated[$locale]['about_title'], null, $validated[$locale]['about_summary']);
                $this->translateSection($recentAgreements, $languages[$locale], $validated[$locale]['agreements_title'], null, $validated[$locale]['agreements_summary']);
                $this->translateSection($director, $languages[$locale], $validated[$locale]['director_title'], $validated[$locale]['director_subtitle'], $validated[$locale]['director_summary']);
                $this->translateSection($stats, $languages[$locale], $validated[$locale]['stats_title'], $validated[$locale]['stats_subtitle'], $validated[$locale]['stats_summary']);
                $this->translateSection($testimonials, $languages[$locale], $validated[$locale]['testimonials_title'], null, $validated[$locale]['testimonials_summary']);
                $this->translateSection($faq, $languages[$locale], $validated[$locale]['faq_title'], $validated[$locale]['faq_subtitle'], $validated[$locale]['faq_summary']);
                $this->translateSection($finalCta, $languages[$locale], $validated[$locale]['final_title'], $validated[$locale]['final_subtitle'], $validated[$locale]['final_summary']);
            }

            $heroBlock = $this->upsertFixedBlock($hero, 'hero_content', 1, $languages, [
                'es' => [
                    'title' => $validated['es']['hero_title'],
                    'subtitle' => $validated['es']['hero_badge'],
                    'summary' => $validated['es']['hero_summary'],
                    'cta_label' => $validated['es']['hero_primary_label'],
                    'secondary_cta_label' => $validated['es']['hero_secondary_label'],
                ],
                'en' => [
                    'title' => $validated['en']['hero_title'],
                    'subtitle' => $validated['en']['hero_badge'],
                    'summary' => $validated['en']['hero_summary'],
                    'cta_label' => $validated['en']['hero_primary_label'],
                    'secondary_cta_label' => $validated['en']['hero_secondary_label'],
                ],
            ], [
                'badgeLink' => $validated['hero_badge_link'],
                'badge_es' => $validated['es']['hero_badge'],
                'badge_en' => $validated['en']['hero_badge'],
                'primaryLink' => $validated['hero_primary_link'],
                'secondaryLink' => $validated['hero_secondary_link'],
            ]);
            $heroBlock->update(['link_url' => $validated['hero_badge_link']]);

            foreach (self::COUNTRIES as $index) {
                $country = $validated['countries'][$index];
                $block = $this->upsertFixedBlock($scholarships, 'scholarship_country_grid_item', $index, $languages, [
                    'es' => ['title' => $country['title_es'], 'summary' => null],
                    'en' => ['title' => $country['title_en'], 'summary' => null],
                ], [
                    'image' => $country['existing_image'] ?: $this->countryFallbacks()[$index]['image'],
                    'slug' => Str::slug($country['slug'] ?: $country['title_es']),
                ]);
                $block->link_url = $country['href'];

                if ($request->hasFile("countries.{$index}.image")) {
                    $block->media_asset_id = $this->storeMedia($request, "countries.{$index}.image", 'home/scholarships', 'Imagen de beca')->id;
                }

                $block->save();
            }

            if ($request->hasFile('about_image')) {
                $settings = $about->settings ?? [];
                $settings['image'] = '/storage/'.ltrim($this->storeMedia($request, 'about_image', 'home/about', 'Imagen de Conócenos')->file_path, '/');
                $about->update(['settings' => $settings]);
            }

            foreach (self::AGREEMENTS as $index) {
                $agreement = $validated['agreements'][$index];
                $block = $this->upsertFixedBlock($recentAgreements, 'recent_agreements_item', $index, $languages, [
                    'es' => ['title' => $agreement['title_es'], 'summary' => null],
                    'en' => ['title' => $agreement['title_en'], 'summary' => null],
                ], [
                    'image' => $agreement['existing_image'] ?: $this->agreementFallbacks()[$index]['image'],
                    'slug' => Str::slug($agreement['title_es']),
                ]);
                $block->link_url = $agreement['href'];

                if ($request->hasFile("agreements.{$index}.image")) {
                    $block->media_asset_id = $this->storeMedia($request, "agreements.{$index}.image", 'home/agreements', 'Imagen de acuerdo')->id;
                }

                $block->save();
            }

            foreach (self::DIRECTOR_BLOCKS as $index) {
                $item = $validated['director_blocks'][$index];
                $this->upsertFixedBlock($director, $index === 1 ? 'mission' : 'purpose', $index, $languages, [
                    'es' => ['title' => $item['title_es'], 'summary' => $item['summary_es']],
                    'en' => ['title' => $item['title_en'], 'summary' => $item['summary_en']],
                ]);
            }

            foreach (self::STATS as $index) {
                $item = $validated['stats'][$index];
                $this->upsertFixedBlock($stats, 'stats_item', $index, $languages, [
                    'es' => ['title' => $item['label_es'], 'summary' => null],
                    'en' => ['title' => $item['label_en'], 'summary' => null],
                ], ['value' => $item['value']]);
            }

            $this->upsertFixedBlock($testimonials, 'testimonials_button', 1, $languages, [
                'es' => ['title' => $validated['es']['testimonials_button_label'], 'summary' => null, 'cta_label' => $validated['es']['testimonials_button_label']],
                'en' => ['title' => $validated['en']['testimonials_button_label'], 'summary' => null, 'cta_label' => $validated['en']['testimonials_button_label']],
            ], [], $validated['testimonials_button_link']);

            $this->syncFaqs($faq, $faqs, $languages);

            $this->upsertFixedBlock($finalCta, 'cta_button', 1, $languages, [
                'es' => ['title' => $validated['es']['final_button_label'], 'summary' => null, 'cta_label' => $validated['es']['final_button_label']],
                'en' => ['title' => $validated['en']['final_button_label'], 'summary' => null, 'cta_label' => $validated['en']['final_button_label']],
            ], [], $validated['final_button_link']);
        });

        return redirect()
            ->route('admin.pages.home.edit', $page)
            ->with('success', 'El contenido de Inicio fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [
            'hero_badge_link' => ['required', 'string', 'max:500'],
            'hero_primary_link' => ['required', 'string', 'max:500'],
            'hero_secondary_link' => ['required', 'string', 'max:500'],
            'testimonials_button_link' => ['required', 'string', 'max:500'],
            'final_button_link' => ['required', 'string', 'max:500'],
            'about_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
        ];

        foreach (['es', 'en'] as $locale) {
            foreach (['page_title', 'hero_badge', 'hero_title', 'hero_primary_label', 'hero_secondary_label', 'scholarships_title', 'scholarships_subtitle', 'about_title', 'agreements_title', 'director_title', 'director_subtitle', 'stats_title', 'stats_subtitle', 'testimonials_title', 'testimonials_button_label', 'faq_title', 'faq_subtitle', 'final_title', 'final_subtitle', 'final_button_label'] as $field) {
                $rules["{$locale}.{$field}"] = ['required', 'string', 'max:180'];
            }

            foreach (['hero_summary', 'scholarships_summary', 'about_summary', 'agreements_summary', 'director_summary', 'stats_summary', 'testimonials_summary', 'faq_summary', 'final_summary'] as $field) {
                $rules["{$locale}.{$field}"] = ['required', 'string', 'max:1000'];
            }
        }

        foreach (self::COUNTRIES as $index) {
            $rules["countries.{$index}.title_es"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["countries.{$index}.title_en"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["countries.{$index}.slug"] = ['required', 'string', 'max:120'];
            $rules["countries.{$index}.href"] = ['required', 'string', 'max:500'];
            $rules["countries.{$index}.existing_image"] = ['nullable', 'string', 'max:900'];
            $rules["countries.{$index}.image"] = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB];
        }

        foreach (self::AGREEMENTS as $index) {
            $rules["agreements.{$index}.title_es"] = ['required', 'string', 'max:160'];
            $rules["agreements.{$index}.title_en"] = ['required', 'string', 'max:160'];
            $rules["agreements.{$index}.href"] = ['required', 'string', 'max:500'];
            $rules["agreements.{$index}.existing_image"] = ['nullable', 'string', 'max:900'];
            $rules["agreements.{$index}.image"] = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB];
        }

        foreach (self::DIRECTOR_BLOCKS as $index) {
            $rules["director_blocks.{$index}.title_es"] = ['required', 'string', 'max:120'];
            $rules["director_blocks.{$index}.title_en"] = ['required', 'string', 'max:120'];
            $rules["director_blocks.{$index}.summary_es"] = ['required', 'string', 'max:1000'];
            $rules["director_blocks.{$index}.summary_en"] = ['required', 'string', 'max:1000'];
        }

        foreach (self::STATS as $index) {
            $rules["stats.{$index}.value"] = ['required', 'string', 'max:30'];
            $rules["stats.{$index}.label_es"] = ['required', 'string', 'max:120'];
            $rules["stats.{$index}.label_en"] = ['required', 'string', 'max:120'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'file' => 'Debes subir un archivo válido.',
            'mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'max' => 'Este campo supera el tamaño permitido.',
            'about_image.max' => 'La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'countries.*.image.max' => 'La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'agreements.*.image.max' => 'La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function validatedFaqs(Request $request): array
    {
        $rows = collect($request->input('faqs', []))
            ->filter(fn ($row) => filled($row['question_es'] ?? null) || filled($row['answer_es'] ?? null))
            ->values()
            ->all();

        $validated = Validator::make(['faqs' => $rows], [
            'faqs' => ['array'],
            'faqs.*.id' => ['nullable', 'integer'],
            'faqs.*.question_es' => ['required', 'string', 'max:260'],
            'faqs.*.question_en' => ['nullable', 'string', 'max:260'],
            'faqs.*.answer_es' => ['required', 'string', 'max:1400'],
            'faqs.*.answer_en' => ['nullable', 'string', 'max:1400'],
        ], [
            'faqs.*.question_es.required' => 'Escribe la pregunta en español.',
            'faqs.*.answer_es.required' => 'Escribe la respuesta en español.',
        ])->validate();

        return collect($validated['faqs'] ?? [])->map(fn ($row) => [
            'id' => isset($row['id']) ? (int) $row['id'] : null,
            'question_es' => trim($row['question_es']),
            'question_en' => trim($row['question_en'] ?? '') ?: trim($row['question_es']),
            'answer_es' => trim($row['answer_es']),
            'answer_en' => trim($row['answer_en'] ?? '') ?: trim($row['answer_es']),
        ])->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => $this->localizedContent($page, 'es'),
            'en' => $this->localizedContent($page, 'en'),
            'hero_badge_link' => $this->block($page, 'home.hero', 1)?->link_url ?? '/presentacion',
            'hero_primary_link' => $this->blockData($page, 'home.hero', 1, 'primaryLink', '/convenios'),
            'hero_secondary_link' => $this->blockData($page, 'home.hero', 1, 'secondaryLink', '/becas-movilidad'),
            'testimonials_button_link' => $this->block($page, 'home.student_testimonials', 1)?->link_url ?? '/becas-movilidad',
            'about_image' => $this->sectionImage($page, 'home.about', '/images/administration/dric-team.jpg'),
            'countries' => $this->countryCards($page),
            'agreements' => $this->agreementCards($page),
            'director_blocks' => $this->directorBlocks($page),
            'stats' => $this->stats($page),
            'faqs' => $this->faqs($page),
            'final_button_link' => $this->block($page, 'home.final_cta', 1)?->link_url ?? '/agendar-cita',
        ];
    }

    private function localizedContent(Page $page, string $locale): array
    {
        return [
            'page_title' => $this->pageValue($page, $locale, 'title', $locale === 'en' ? 'Home' : 'Inicio'),
            'hero_badge' => $this->heroBadgeValue($page, $locale),
            'hero_title' => $this->sectionValue($page, 'home.hero', $locale, 'title', $locale === 'en' ? 'Connecting global minds' : 'Conectando mentes globales'),
            'hero_summary' => $this->blockValue($page, 'home.hero', 1, $locale, 'summary', $locale === 'en' ? 'Discover the opportunities DRIC offers to strengthen your academic future.' : 'Conoce las oportunidades que la DRIC ofrece para fortalecer tu futuro académico.'),
            'hero_primary_label' => $this->blockValue($page, 'home.hero', 1, $locale, 'cta_label', $locale === 'en' ? 'Agreements' : 'Convenios'),
            'hero_secondary_label' => $this->blockValue($page, 'home.hero', 1, $locale, 'secondary_cta_label', $locale === 'en' ? 'Scholarships and mobility' : 'Becas y movilidad'),
            'scholarships_title' => $this->sectionValue($page, 'home.scholarships', $locale, 'title', $locale === 'en' ? 'Scholarship Calls' : 'Convocatoria de Becas'),
            'scholarships_subtitle' => $this->sectionValue($page, 'home.scholarships', $locale, 'subtitle', $locale === 'en' ? 'Explore international academic opportunities.' : 'Explora oportunidades académicas internacionales.'),
            'scholarships_summary' => $this->sectionValue($page, 'home.scholarships', $locale, 'summary', $locale === 'en' ? 'Access scholarship, mobility, and academic exchange opportunities.' : 'Accede a convocatorias de becas, movilidad e intercambio académico.'),
            'about_title' => $this->sectionValue($page, 'home.about', $locale, 'title', $locale === 'en' ? 'About us' : 'Conócenos'),
            'about_summary' => $this->sectionValue($page, 'home.about', $locale, 'summary', $locale === 'en' ? 'DRIC strengthens university internationalization through agreements, mobility, cooperation, and academic partnerships.' : 'La DRIC fortalece la internacionalización universitaria mediante convenios, movilidad, cooperación y vinculación académica.'),
            'agreements_title' => $this->sectionValue($page, 'home.recent_agreements', $locale, 'title', $locale === 'en' ? 'Recent agreements' : 'Acuerdos recientes'),
            'agreements_summary' => $this->sectionValue($page, 'home.recent_agreements', $locale, 'summary', $locale === 'en' ? 'Learn about recent national and international cooperation actions.' : 'Conoce las acciones recientes de cooperación nacional e internacional.'),
            'director_title' => $this->sectionValue($page, 'home.director', $locale, 'title', 'Director: Omar Morales Delgadillo'),
            'director_subtitle' => $this->sectionValue($page, 'home.director', $locale, 'subtitle', $locale === 'en' ? 'International Relations and Agreements Office' : 'Dirección de Relaciones Internacionales y Convenios'),
            'director_summary' => $this->sectionValue($page, 'home.director', $locale, 'summary', $locale === 'en' ? 'DRIC reports directly to the Rectorate in the fulfillment of its functions.' : 'La DRIC depende directamente del Rectorado para el cumplimiento de sus funciones.'),
            'stats_title' => $this->sectionValue($page, 'home.stats', $locale, 'title', $locale === 'en' ? 'Institutional results' : 'Resultados institucionales'),
            'stats_subtitle' => $this->sectionValue($page, 'home.stats', $locale, 'subtitle', $locale === 'en' ? 'Impact of international cooperation.' : 'Impacto de la cooperación internacional.'),
            'stats_summary' => $this->sectionValue($page, 'home.stats', $locale, 'summary', $locale === 'en' ? 'Key indicators of institutional management.' : 'Indicadores destacados de la gestión institucional.'),
            'testimonials_title' => $this->sectionValue($page, 'home.student_testimonials', $locale, 'title', $locale === 'en' ? 'Student experiences' : 'Experiencias de los estudiantes'),
            'testimonials_summary' => $this->sectionValue($page, 'home.student_testimonials', $locale, 'summary', $locale === 'en' ? 'Real stories about academic mobility, international cooperation, and opportunities that transform university life.' : 'Historias reales sobre movilidad académica, cooperación internacional y oportunidades que transforman la vida universitaria.'),
            'testimonials_button_label' => $this->blockValue($page, 'home.student_testimonials', 1, $locale, 'cta_label', $locale === 'en' ? 'View programs' : 'Ver programas'),
            'faq_title' => $this->sectionValue($page, 'home.faq', $locale, 'title', 'FAQ'),
            'faq_subtitle' => $this->sectionValue($page, 'home.faq', $locale, 'subtitle', $locale === 'en' ? 'Find answers to frequently asked questions about our programs.' : 'Encuentra respuestas a preguntas frecuentes acerca de nuestros programas.'),
            'faq_summary' => $this->sectionValue($page, 'home.faq', $locale, 'summary', $locale === 'en' ? 'Essential information for national and international students and visitors.' : 'Información esencial para estudiantes nacionales, extranjeros y visitantes.'),
            'final_title' => $this->sectionValue($page, 'home.final_cta', $locale, 'title', $locale === 'en' ? 'Take the next step in your academic journey' : 'Da el siguiente paso en tu camino académico'),
            'final_subtitle' => $this->sectionValue($page, 'home.final_cta', $locale, 'subtitle', $locale === 'en' ? 'Discover opportunities that can transform your future.' : 'Descubre oportunidades que pueden transformar tu futuro.'),
            'final_summary' => $this->sectionValue($page, 'home.final_cta', $locale, 'summary', $locale === 'en' ? 'Schedule an appointment and receive guidance on programs, agreements, and international scholarships.' : 'Agenda una cita y recibe orientación sobre programas, convenios y becas internacionales.'),
            'final_button_label' => $this->blockValue($page, 'home.final_cta', 1, $locale, 'cta_label', $locale === 'en' ? 'Schedule an appointment' : 'Agenda una cita'),
        ];
    }

    private function countryCards(Page $page): array
    {
        $fallbacks = $this->countryFallbacks();
        $section = $page->sections->firstWhere('section_key', 'home.scholarships');

        foreach (self::COUNTRIES as $index) {
            $block = $section?->contentBlocks->firstWhere('sort_order', $index);
            $fallbacks[$index]['title_es'] = $block?->translations->firstWhere('language.code', 'es')?->title ?? $fallbacks[$index]['title_es'];
            $fallbacks[$index]['title_en'] = $block?->translations->firstWhere('language.code', 'en')?->title ?? $fallbacks[$index]['title_en'];
            $fallbacks[$index]['slug'] = $block?->data['slug'] ?? $fallbacks[$index]['slug'];
            $fallbacks[$index]['href'] = $block?->link_url ?? $fallbacks[$index]['href'];
            $fallbacks[$index]['image'] = $this->blockImage($block, $fallbacks[$index]['image']);
            $fallbacks[$index]['existing_image'] = $fallbacks[$index]['image'];
        }

        return $fallbacks;
    }

    private function countryFallbacks(): array
    {
        return [
            1 => ['title_es' => 'Bélgica', 'title_en' => 'Belgium', 'slug' => 'belgica', 'href' => '/becas-movilidad/becas/belgica', 'image' => '/images/scholarships/belgium.png'],
            2 => ['title_es' => 'Francia', 'title_en' => 'France', 'slug' => 'francia', 'href' => '/becas-movilidad/becas/francia', 'image' => '/images/scholarships/france.jpg'],
            3 => ['title_es' => 'Corea del Sur', 'title_en' => 'South Korea', 'slug' => 'corea-del-sur', 'href' => '/becas-movilidad/becas/corea-del-sur', 'image' => '/images/scholarships/south-korea.jpg'],
            4 => ['title_es' => 'Italia', 'title_en' => 'Italy', 'slug' => 'italia', 'href' => '/becas-movilidad/becas/italia', 'image' => '/images/scholarships/italy.jpg'],
            5 => ['title_es' => 'Japón', 'title_en' => 'Japan', 'slug' => 'japon', 'href' => '/becas-movilidad/becas/japon', 'image' => '/images/scholarships/japan.jpg'],
            6 => ['title_es' => 'Holanda', 'title_en' => 'Netherlands', 'slug' => 'holanda', 'href' => '/becas-movilidad/becas/holanda', 'image' => '/images/scholarships/netherlands.jpg'],
            7 => ['title_es' => 'Suecia', 'title_en' => 'Sweden', 'slug' => 'suecia', 'href' => '/becas-movilidad/becas/suecia', 'image' => '/images/scholarships/sweden.jpg'],
            8 => ['title_es' => 'Suiza', 'title_en' => 'Switzerland', 'slug' => 'suiza', 'href' => '/becas-movilidad/becas/suiza', 'image' => '/images/scholarships/switzerland.jpg'],
            9 => ['title_es' => 'Alemania', 'title_en' => 'Germany', 'slug' => 'alemania', 'href' => '/becas-movilidad/becas/alemania', 'image' => '/images/scholarships/germany.jpg'],
        ];
    }

    private function agreementCards(Page $page): array
    {
        $fallbacks = $this->agreementFallbacks();
        $section = $page->sections->firstWhere('section_key', 'home.recent_agreements');

        foreach (self::AGREEMENTS as $index) {
            $block = $section?->contentBlocks->firstWhere('sort_order', $index);
            $fallbacks[$index]['title_es'] = $block?->translations->firstWhere('language.code', 'es')?->title ?? $fallbacks[$index]['title_es'];
            $fallbacks[$index]['title_en'] = $block?->translations->firstWhere('language.code', 'en')?->title ?? $fallbacks[$index]['title_en'];
            $fallbacks[$index]['href'] = $block?->link_url ?? $fallbacks[$index]['href'];
            $fallbacks[$index]['image'] = $this->blockImage($block, $fallbacks[$index]['image']);
            $fallbacks[$index]['existing_image'] = $fallbacks[$index]['image'];
        }

        return $fallbacks;
    }

    private function agreementFallbacks(): array
    {
        return [
            1 => ['title_es' => 'Cooperación académica internacional', 'title_en' => 'International academic cooperation', 'href' => '/internacionalizacion', 'image' => '/images/agreements/agreement-1.jpg'],
            2 => ['title_es' => 'Alianzas estratégicas', 'title_en' => 'Strategic partnerships', 'href' => '/membresias', 'image' => '/images/agreements/agreement-2.jpg'],
            3 => ['title_es' => 'Vinculación institucional', 'title_en' => 'Institutional relations', 'href' => 'https://conveniosdric.umss.edu.bo/convenios', 'image' => '/images/agreements/agreement-3.jpg'],
        ];
    }

    private function directorBlocks(Page $page): array
    {
        $fallbacks = [
            1 => ['title_es' => 'Misión', 'title_en' => 'Mission', 'summary_es' => 'Promover, coordinar y consolidar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS.', 'summary_en' => 'To promote, coordinate, and consolidate international and national cooperation, as well as UMSS interinstitutional coordination.'],
            2 => ['title_es' => 'Propósito', 'title_en' => 'Purpose', 'summary_es' => 'Fortalecer la internacionalización universitaria mediante convenios, proyectos, becas, movilidad y cooperación académica.', 'summary_en' => 'To strengthen university internationalization through agreements, projects, scholarships, mobility, and academic cooperation.'],
        ];
        $section = $page->sections->firstWhere('section_key', 'home.director');

        foreach (self::DIRECTOR_BLOCKS as $index) {
            $block = $section?->contentBlocks->firstWhere('sort_order', $index);
            $fallbacks[$index]['title_es'] = $block?->translations->firstWhere('language.code', 'es')?->title ?? $fallbacks[$index]['title_es'];
            $fallbacks[$index]['title_en'] = $block?->translations->firstWhere('language.code', 'en')?->title ?? $fallbacks[$index]['title_en'];
            $fallbacks[$index]['summary_es'] = $block?->translations->firstWhere('language.code', 'es')?->summary ?? $fallbacks[$index]['summary_es'];
            $fallbacks[$index]['summary_en'] = $block?->translations->firstWhere('language.code', 'en')?->summary ?? $fallbacks[$index]['summary_en'];
        }

        return $fallbacks;
    }

    private function stats(Page $page): array
    {
        $fallbacks = [
            1 => ['value' => '2700+', 'label_es' => 'Convenios acordados', 'label_en' => 'Agreements signed'],
            2 => ['value' => '96%', 'label_es' => 'Estudiantes satisfechos', 'label_en' => 'Satisfied students'],
            3 => ['value' => '37+', 'label_es' => 'Años de experiencia', 'label_en' => 'Years of experience'],
        ];
        $section = $page->sections->firstWhere('section_key', 'home.stats');

        foreach (self::STATS as $index) {
            $block = $section?->contentBlocks->firstWhere('sort_order', $index);
            $fallbacks[$index]['value'] = $block?->data['value'] ?? $fallbacks[$index]['value'];
            $fallbacks[$index]['label_es'] = $block?->translations->firstWhere('language.code', 'es')?->title ?? $fallbacks[$index]['label_es'];
            $fallbacks[$index]['label_en'] = $block?->translations->firstWhere('language.code', 'en')?->title ?? $fallbacks[$index]['label_en'];
        }

        return $fallbacks;
    }

    private function faqs(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'home.faq');

        return ($section?->contentBlocks ?? collect())
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'question_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'question_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'answer_es' => $block->translations->firstWhere('language.code', 'es')?->summary ?? '',
                'answer_en' => $block->translations->firstWhere('language.code', 'en')?->summary ?? '',
            ])
            ->all();
    }

    private function syncFaqs(Section $section, array $faqs, $languages): void
    {
        $keepIds = collect($faqs)->pluck('id')->filter()->all();
        $query = $section->contentBlocks()->where('block_type', 'faq_item');

        if (count($keepIds) > 0) {
            $query->whereNotIn('id', $keepIds);
        }

        $query->get()->each(fn (ContentBlock $block) => $block->delete());

        foreach ($faqs as $index => $faq) {
            $block = $faq['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $faq['id'])->first()
                : null;
            $block ??= new ContentBlock(['section_id' => $section->id, 'block_type' => 'faq_item']);
            $block->fill(['sort_order' => $index + 1, 'is_active' => true, 'link_url' => null, 'data' => []]);
            $block->save();

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $faq["question_{$locale}"],
                        'subtitle' => null,
                        'summary' => $faq["answer_{$locale}"],
                        'body' => null,
                        'cta_label' => null,
                    ]
                );
            }
        }
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder, array $settings): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            [
                'section_type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'settings' => $settings,
            ]
        );
    }

    private function translateSection(Section $section, Language $language, ?string $title, ?string $subtitle, ?string $summary): void
    {
        SectionTranslation::updateOrCreate(
            ['section_id' => $section->id, 'language_id' => $language->id],
            ['title' => $title, 'subtitle' => $subtitle, 'summary' => $summary, 'body' => null]
        );
    }

    private function upsertFixedBlock(Section $section, string $type, int $sortOrder, $languages, array $translations, array $data = [], ?string $linkUrl = null): ContentBlock
    {
        $block = ContentBlock::firstOrNew(['section_id' => $section->id, 'sort_order' => $sortOrder]);
        $block->fill([
            'block_type' => $type,
            'is_active' => true,
            'link_url' => $linkUrl ?? $block->link_url,
            'data' => $data,
        ]);
        $block->save();

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'] ?? null,
                    'subtitle' => $translations[$locale]['subtitle'] ?? null,
                    'summary' => $translations[$locale]['summary'] ?? null,
                    'body' => $translations[$locale]['body'] ?? null,
                    'cta_label' => $translations[$locale]['cta_label'] ?? null,
                    'secondary_cta_label' => $translations[$locale]['secondary_cta_label'] ?? null,
                ]
            );
        }

        return $block;
    }

    private function storeMedia(Request $request, string $field, string $prefix, string $altText): MediaAsset
    {
        $file = $request->file($field);
        $path = $file->store($prefix, 'public');

        $media = MediaAsset::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'disk' => 'public',
            'uploaded_by' => $request->user()->id,
        ]);

        foreach (Language::query()->whereIn('code', ['es', 'en'])->get() as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                ['alt_text' => $altText, 'caption' => null]
            );
        }

        return $media;
    }

    private function mergedSettings(Page $page, string $key, array $fallback): array
    {
        return array_merge($fallback, $page->sections->firstWhere('section_key', $key)?->settings ?? []);
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionImage(Page $page, string $key, string $fallback): string
    {
        $image = $page->sections->firstWhere('section_key', $key)?->settings['image'] ?? null;

        return is_string($image) && trim($image) !== '' ? $image : $fallback;
    }

    private function block(Page $page, string $sectionKey, int $sortOrder): ?ContentBlock
    {
        return $page->sections->firstWhere('section_key', $sectionKey)?->contentBlocks->firstWhere('sort_order', $sortOrder);
    }

    private function blockValue(Page $page, string $sectionKey, int $sortOrder, string $locale, string $field, string $fallback): string
    {
        return $this->block($page, $sectionKey, $sortOrder)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockData(Page $page, string $sectionKey, int $sortOrder, string $key, string $fallback): string
    {
        $value = $this->block($page, $sectionKey, $sortOrder)?->data[$key] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $fallback;
    }

    private function heroBadgeValue(Page $page, string $locale): string
    {
        $block = $this->block($page, 'home.hero', 1);
        $data = $block?->data ?? [];
        $localizedBadge = $data["badge_{$locale}"] ?? null;

        if (is_string($localizedBadge) && trim($localizedBadge) !== '') {
            return $localizedBadge;
        }

        if ($locale === 'es' && isset($data['badge']) && is_string($data['badge']) && trim($data['badge']) !== '') {
            return $data['badge'];
        }

        $storedSubtitle = $block?->translations->firstWhere('language.code', $locale)?->subtitle;
        $sectionSubtitle = $page->sections->firstWhere('section_key', 'home.hero')?->translations->firstWhere('language.code', $locale)?->subtitle;

        if (is_string($storedSubtitle) && trim($storedSubtitle) !== '' && $storedSubtitle !== $sectionSubtitle) {
            return $storedSubtitle;
        }

        return $locale === 'en' ? 'Presentation' : 'Presentación';
    }

    private function blockImage(?ContentBlock $block, string $fallback): string
    {
        if ($block?->mediaAsset?->file_path) {
            return '/storage/'.ltrim($block->mediaAsset->file_path, '/');
        }

        $image = $block?->data['image'] ?? null;

        return is_string($image) && trim($image) !== '' ? $image : $fallback;
    }

    private function authorizeHomeAccess(Page $page): void
    {
        abort_unless($page->slug === 'inicio', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
