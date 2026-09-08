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

class ScholarshipHubContentController extends Controller
{
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';
    private const CARDS = [1, 2, 3, 4];

    public function edit(Page $page): View
    {
        $this->authorizeScholarshipHubAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.scholarship-hub-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'cardLabels' => $this->cardLabels(),
            'scholarshipPage' => Page::query()->where('slug', 'becas')->first(),
            'awardsPage' => Page::query()->where('slug', 'premios-eventos-cursos-concursos')->first(),
            'nationalForeignInfoPage' => Page::query()->where('slug', 'informacion-nacionales-extranjeros')->first(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeScholarshipHubAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();

        DB::transaction(function () use ($request, $validated, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'scholarship_hub.hero', 'scholarship_hub_hero', 1);
            $explore = $this->upsertSection($page, 'scholarship_hub.explore', 'scholarship_hub_explore', 2);
            $cards = $this->upsertSection($page, 'scholarship_hub.cards', 'scholarship_hub_cards', 3);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['badge'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['badge'],
                        'summary' => $validated[$locale]['intro'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $explore->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['explore_title'],
                        'subtitle' => $validated[$locale]['explore_badge'],
                        'summary' => $validated[$locale]['explore_intro'],
                        'body' => null,
                    ]
                );
            }

            foreach (self::CARDS as $index) {
                $fallback = $this->cardFallbacks()[$index];
                $this->upsertBlock($cards, "scholarship_hub.card.{$index}", 'scholarship_hub_card', $index, $languages, [
                    'es' => [
                        'title' => $validated['cards'][$index]['title_es'],
                        'summary' => $validated['cards'][$index]['description_es'],
                        'cta_label' => $validated['cards'][$index]['label_es'],
                    ],
                    'en' => [
                        'title' => $validated['cards'][$index]['title_en'],
                        'summary' => $validated['cards'][$index]['description_en'],
                        'cta_label' => $validated['cards'][$index]['label_en'],
                    ],
                ], [
                    'href' => $validated['cards'][$index]['href'],
                    'icon' => $fallback['icon'],
                    'accent' => $fallback['accent'],
                    'locked_design' => true,
                ]);
            }
        });

        return redirect()
            ->route('admin.pages.scholarship-hub.edit', $page)
            ->with('success', 'El contenido de Becas y Movilidad fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.badge"] = ['required', 'string', 'max:80'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:900'];
            $rules["{$locale}.explore_badge"] = ['required', 'string', 'max:100', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.explore_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.explore_intro"] = ['required', 'string', 'max:900'];
        }

        foreach (self::CARDS as $index) {
            $rules["cards.{$index}.title_es"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["cards.{$index}.title_en"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["cards.{$index}.description_es"] = ['required', 'string', 'max:700'];
            $rules["cards.{$index}.description_en"] = ['required', 'string', 'max:700'];
            $rules["cards.{$index}.label_es"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["cards.{$index}.label_en"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["cards.{$index}.href"] = ['required', 'string', 'max:500'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'badge' => $this->sectionValue($page, 'scholarship_hub.hero', 'es', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'es', 'title', 'Becas y Movilidad'),
                'intro' => $this->sectionValue($page, 'scholarship_hub.hero', 'es', 'summary', 'La DRIC impulsa la internacionalización académica mediante becas, programas de movilidad, pasantías, convocatorias y orientación institucional para la comunidad nacional e internacional.'),
                'explore_badge' => $this->sectionValue($page, 'scholarship_hub.explore', 'es', 'subtitle', 'Explora oportunidades'),
                'explore_title' => $this->sectionValue($page, 'scholarship_hub.explore', 'es', 'title', 'Rutas académicas internacionales'),
                'explore_intro' => $this->sectionValue($page, 'scholarship_hub.explore', 'es', 'summary', 'Esta sección reúne becas, movilidad, pasantías, convocatorias e información institucional para orientar a la comunidad universitaria.'),
            ],
            'en' => [
                'badge' => $this->sectionValue($page, 'scholarship_hub.hero', 'en', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'en', 'title', 'Scholarships and Mobility'),
                'intro' => $this->sectionValue($page, 'scholarship_hub.hero', 'en', 'summary', 'DRIC promotes academic internationalization through scholarships, mobility programs, internships, calls and institutional guidance for national and international communities.'),
                'explore_badge' => $this->sectionValue($page, 'scholarship_hub.explore', 'en', 'subtitle', 'Explore opportunities'),
                'explore_title' => $this->sectionValue($page, 'scholarship_hub.explore', 'en', 'title', 'International academic pathways'),
                'explore_intro' => $this->sectionValue($page, 'scholarship_hub.explore', 'en', 'summary', 'This section brings together scholarships, mobility, internships, calls and institutional information to guide the university community.'),
            ],
            'cards' => $this->cards($page),
        ];
    }

    private function cards(Page $page): array
    {
        $fallbacks = $this->cardFallbacks();

        foreach (self::CARDS as $index) {
            $fallbacks[$index]['title_es'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'es', 'title', $fallbacks[$index]['title_es']);
            $fallbacks[$index]['title_en'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'en', 'title', $fallbacks[$index]['title_en']);
            $fallbacks[$index]['description_es'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'es', 'summary', $fallbacks[$index]['description_es']);
            $fallbacks[$index]['description_en'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'en', 'summary', $fallbacks[$index]['description_en']);
            $fallbacks[$index]['label_es'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'es', 'cta_label', $fallbacks[$index]['label_es']);
            $fallbacks[$index]['label_en'] = $this->blockValue($page, "scholarship_hub.card.{$index}", 'en', 'cta_label', $fallbacks[$index]['label_en']);
            $fallbacks[$index]['href'] = $this->blockData($page, "scholarship_hub.card.{$index}", 'href', $fallbacks[$index]['href']);
        }

        return $fallbacks;
    }

    private function cardFallbacks(): array
    {
        return [
            1 => ['label' => 'Becas', 'title_es' => 'Becas de pregrado y posgrado', 'title_en' => 'Undergraduate and postgraduate scholarships', 'description_es' => 'Programas de becas ofertados por gobiernos, universidades y organismos internacionales.', 'description_en' => 'Scholarship opportunities offered by governments, universities and international organizations.', 'label_es' => 'Ver becas', 'label_en' => 'View scholarships', 'href' => '/becas-movilidad/becas', 'icon' => 'school', 'accent' => '#E30613'],
            2 => ['label' => 'Movilidad', 'title_es' => 'Movilidad y pasantías internacionales', 'title_en' => 'Mobility and international internships', 'description_es' => 'Programas de movilidad docente, estudiantil, administrativa y pasantías internacionales.', 'description_en' => 'Academic, teaching, student and administrative mobility programs.', 'label_es' => 'Ver programas', 'label_en' => 'View programs', 'href' => '/becas-movilidad/movilidad-pasantias', 'icon' => 'flight', 'accent' => '#003770'],
            3 => ['label' => 'Convocatorias', 'title_es' => 'Premios, eventos, cursos y concursos', 'title_en' => 'Awards, events, courses and contests', 'description_es' => 'Convocatorias, cursos, concursos y oportunidades académicas para la comunidad universitaria.', 'description_en' => 'Calls, courses, contests and academic opportunities for the university community.', 'label_es' => 'Ver convocatorias', 'label_en' => 'View calls', 'href' => '/becas-movilidad/premios-eventos-cursos-concursos', 'icon' => 'awards', 'accent' => '#E30613'],
            4 => ['label' => 'Información', 'title_es' => 'Información para nacionales y extranjeros', 'title_en' => 'Information for nationals and foreigners', 'description_es' => 'Información útil, trámites y orientación para ciudadanos nacionales y extranjeros.', 'description_en' => 'Useful information, procedures and guidance for national and international visitors.', 'label_es' => 'Ver información', 'label_en' => 'View information', 'href' => '/becas-movilidad/informacion-nacionales-extranjeros', 'icon' => 'info', 'accent' => '#003770'],
        ];
    }

    private function cardLabels(): array
    {
        return collect($this->cardFallbacks())->map(fn ($item) => $item['label'])->all();
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): void
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
                    'subtitle' => $translations[$locale]['subtitle'] ?? null,
                    'summary' => $translations[$locale]['summary'] ?? null,
                    'body' => $translations[$locale]['body'] ?? null,
                    'cta_label' => $translations[$locale]['cta_label'] ?? null,
                ]
            );
        }
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
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockData(Page $page, string $key, string $dataKey, string $fallback): string
    {
        $value = $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key)?->data[$dataKey] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $fallback;
    }

    private function authorizeScholarshipHubAccess(Page $page): void
    {
        abort_unless($page->slug === 'becas-movilidad', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
