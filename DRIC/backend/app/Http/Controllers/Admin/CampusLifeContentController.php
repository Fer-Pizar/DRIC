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

class CampusLifeContentController extends Controller
{
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    private const STATS = [1, 2, 3];
    private const FEATURES = [1, 2, 3];
    private const STORIES = [1, 2, 3, 4];

    public function edit(Page $page): View
    {
        $this->authorizeCampusAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.campus-life-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'storyLabels' => $this->storyLabels(),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeCampusAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();

        DB::transaction(function () use ($request, $validated, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');
            $hero = $this->upsertSection($page, 'campus.hero', 'campus_hero', 1);
            $official = $this->upsertSection($page, 'campus.official', 'campus_official_card', 2);
            $stats = $this->upsertSection($page, 'campus.stats', 'campus_stats', 3);
            $features = $this->upsertSection($page, 'campus.features', 'campus_features', 4);
            $basic = $this->upsertSection($page, 'campus.basic', 'campus_basic', 5);
            $stories = $this->upsertSection($page, 'campus.stories', 'campus_stories', 6);

            foreach (['es', 'en'] as $locale) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'menu_title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['badge'],
                        'summary' => $validated[$locale]['subtitle'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $hero->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['title'],
                        'subtitle' => $validated[$locale]['badge'],
                        'summary' => $validated[$locale]['subtitle'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $official->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['official_title'],
                        'subtitle' => $validated[$locale]['official_label'],
                        'summary' => $validated[$locale]['basic_text'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $basic->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['basic_title'],
                        'subtitle' => $validated[$locale]['basic_kicker'],
                        'summary' => $validated[$locale]['basic_text'],
                        'body' => null,
                    ]
                );
            }

            $this->upsertBlock($hero, 'campus.hero.image', 'campus_hero_image', 1, $languages, [], ['image' => '/images/campus-life/uni-view.png', 'locked_image' => true]);
            $this->upsertBlock($official, 'campus.official.logo', 'campus_logo', 1, $languages, [], ['image' => '/images/campus-life/umss-logo.png', 'url' => $validated['official_url'], 'locked_image' => true]);

            foreach (self::STATS as $index) {
                $this->upsertBlock($stats, "campus.stat.{$index}", 'campus_stat', $index, $languages, [
                    'es' => ['title' => $validated['stats'][$index]['value'], 'summary' => $validated['stats'][$index]['label_es']],
                    'en' => ['title' => $validated['stats'][$index]['value'], 'summary' => $validated['stats'][$index]['label_en']],
                ]);
            }

            foreach (self::FEATURES as $index) {
                $this->upsertBlock($features, "campus.feature.{$index}", 'campus_feature', $index, $languages, [
                    'es' => ['title' => $validated['features'][$index]['title_es'], 'summary' => $validated['features'][$index]['text_es']],
                    'en' => ['title' => $validated['features'][$index]['title_en'], 'summary' => $validated['features'][$index]['text_en']],
                ], ['icon' => $this->featureIcon($index)]);
            }

            foreach (self::STORIES as $index) {
                $fallback = $this->storyFallbacks()[$index];

                $this->upsertBlock($stories, "campus.story.{$index}", 'campus_story', $index, $languages, [
                    'es' => [
                        'title' => $validated['stories'][$index]['title_es'],
                        'subtitle' => $validated['stories'][$index]['eyebrow_es'],
                        'summary' => $validated['stories'][$index]['text_es'],
                        'body' => null,
                        'cta_label' => $validated['stories'][$index]['button_es'] ?? null,
                    ],
                    'en' => [
                        'title' => $validated['stories'][$index]['title_en'],
                        'subtitle' => $validated['stories'][$index]['eyebrow_en'],
                        'summary' => $validated['stories'][$index]['text_en'],
                        'body' => null,
                        'cta_label' => $validated['stories'][$index]['button_en'] ?? null,
                    ],
                ], ['url' => $validated['stories'][$index]['url'], 'image' => $fallback['image_url'], 'locked_image' => true]);
            }
        });

        return redirect()
            ->route('admin.pages.campus-life.edit', $page)
            ->with('success', 'El contenido de Campus Life fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [
            'official_url' => ['required', 'url', 'max:500'],
        ];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.badge"] = ['required', 'string', 'max:120'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.subtitle"] = ['required', 'string', 'max:800'];
            $rules["{$locale}.official_label"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.official_title"] = ['required', 'string', 'max:160'];
            $rules["{$locale}.basic_kicker"] = ['required', 'string', 'max:140'];
            $rules["{$locale}.basic_title"] = ['required', 'string', 'max:220'];
            $rules["{$locale}.basic_text"] = ['required', 'string', 'max:1200'];
        }

        foreach (self::STATS as $index) {
            $rules["stats.{$index}.value"] = ['required', 'string', 'max:30'];
            $rules["stats.{$index}.label_es"] = ['required', 'string', 'max:120'];
            $rules["stats.{$index}.label_en"] = ['required', 'string', 'max:120'];
        }

        foreach (self::FEATURES as $index) {
            $rules["features.{$index}.title_es"] = ['required', 'string', 'max:160'];
            $rules["features.{$index}.title_en"] = ['required', 'string', 'max:160'];
            $rules["features.{$index}.text_es"] = ['required', 'string', 'max:700'];
            $rules["features.{$index}.text_en"] = ['required', 'string', 'max:700'];
        }

        foreach (self::STORIES as $index) {
            $rules["stories.{$index}.eyebrow_es"] = ['required', 'string', 'max:140'];
            $rules["stories.{$index}.eyebrow_en"] = ['required', 'string', 'max:140'];
            $rules["stories.{$index}.title_es"] = ['required', 'string', 'max:220'];
            $rules["stories.{$index}.title_en"] = ['required', 'string', 'max:220'];
            $rules["stories.{$index}.text_es"] = ['required', 'string', 'max:1400'];
            $rules["stories.{$index}.text_en"] = ['required', 'string', 'max:1400'];
            $rules["stories.{$index}.button_es"] = ['nullable', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["stories.{$index}.button_en"] = ['nullable', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["stories.{$index}.url"] = ['required', 'url', 'max:500'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://www.umss.edu.bo',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'badge' => $this->sectionValue($page, 'campus.hero', 'es', 'subtitle', 'Experiencia UMSS'),
                'title' => $this->pageValue($page, 'es', 'title', 'Campus Life'),
                'subtitle' => $this->sectionValue($page, 'campus.hero', 'es', 'summary', 'Una universidad enraizada en Cochabamba, conectada con Bolivia y abierta al mundo.'),
                'official_label' => $this->sectionValue($page, 'campus.official', 'es', 'subtitle', 'Universidad Mayor de San Simón'),
                'official_title' => $this->sectionValue($page, 'campus.official', 'es', 'title', 'Sitio oficial UMSS'),
                'basic_kicker' => $this->sectionValue($page, 'campus.basic', 'es', 'subtitle', 'Información básica'),
                'basic_title' => $this->sectionValue($page, 'campus.basic', 'es', 'title', 'Una universidad pública histórica con impacto regional'),
                'basic_text' => $this->sectionValue($page, 'campus.basic', 'es', 'summary', 'La Universidad Mayor de San Simón fue fundada por Ley del 5 de noviembre de 1832. Es una universidad pública autónoma con funciones de formación académica, investigación científica y tecnológica e interacción social.'),
            ],
            'en' => [
                'badge' => $this->sectionValue($page, 'campus.hero', 'en', 'subtitle', 'UMSS experience'),
                'title' => $this->pageValue($page, 'en', 'title', 'Campus Life'),
                'subtitle' => $this->sectionValue($page, 'campus.hero', 'en', 'summary', 'A university rooted in Cochabamba, connected to Bolivia and open to the world.'),
                'official_label' => $this->sectionValue($page, 'campus.official', 'en', 'subtitle', 'Universidad Mayor de San Simón'),
                'official_title' => $this->sectionValue($page, 'campus.official', 'en', 'title', 'Official UMSS website'),
                'basic_kicker' => $this->sectionValue($page, 'campus.basic', 'en', 'subtitle', 'Basic information'),
                'basic_title' => $this->sectionValue($page, 'campus.basic', 'en', 'title', 'A historic public university with regional impact'),
                'basic_text' => $this->sectionValue($page, 'campus.basic', 'en', 'summary', 'Universidad Mayor de San Simón was founded by law on November 5, 1832. Today it is a public autonomous university with academic, scientific, technological and social outreach functions.'),
            ],
            'official_url' => $this->blockData($page, 'campus.official.logo', 'url', 'https://www.umss.edu.bo/'),
            'stats' => $this->stats($page),
            'features' => $this->features($page),
            'stories' => $this->stories($page),
        ];
    }

    private function stats(Page $page): array
    {
        $fallbacks = [
            1 => ['value' => '1832', 'label_es' => 'Año de fundación', 'label_en' => 'Year of foundation'],
            2 => ['value' => '10+', 'label_es' => 'Facultades y unidades académicas', 'label_en' => 'Faculties and academic units'],
            3 => ['value' => '77k+', 'label_es' => 'Estudiantes y comunidad académica', 'label_en' => 'Students and academic community'],
        ];

        foreach (self::STATS as $index) {
            $fallbacks[$index]['value'] = $this->blockValue($page, "campus.stat.{$index}", 'es', 'title', $fallbacks[$index]['value']);
            $fallbacks[$index]['label_es'] = $this->blockValue($page, "campus.stat.{$index}", 'es', 'summary', $fallbacks[$index]['label_es']);
            $fallbacks[$index]['label_en'] = $this->blockValue($page, "campus.stat.{$index}", 'en', 'summary', $fallbacks[$index]['label_en']);
        }

        return $fallbacks;
    }

    private function features(Page $page): array
    {
        $fallbacks = [
            1 => ['title_es' => 'Programas académicos', 'title_en' => 'Academic programs', 'text_es' => 'Formación de pregrado y posgrado en diversas áreas del conocimiento.', 'text_en' => 'Undergraduate and postgraduate education across diverse areas of knowledge.'],
            2 => ['title_es' => 'Contribución a la comunidad', 'title_en' => 'Community contribution', 'text_es' => 'Enseñanza, investigación e interacción social vinculadas a las necesidades regionales.', 'text_en' => 'Teaching, research and social outreach connected with regional needs.'],
            3 => ['title_es' => 'Orientación internacional', 'title_en' => 'International orientation', 'text_es' => 'Cooperación, convenios, movilidad y oportunidades académicas promovidas desde la DRIC.', 'text_en' => 'Cooperation, agreements, mobility and academic opportunities promoted through DRIC.'],
        ];

        foreach (self::FEATURES as $index) {
            $fallbacks[$index]['title_es'] = $this->blockValue($page, "campus.feature.{$index}", 'es', 'title', $fallbacks[$index]['title_es']);
            $fallbacks[$index]['title_en'] = $this->blockValue($page, "campus.feature.{$index}", 'en', 'title', $fallbacks[$index]['title_en']);
            $fallbacks[$index]['text_es'] = $this->blockValue($page, "campus.feature.{$index}", 'es', 'summary', $fallbacks[$index]['text_es']);
            $fallbacks[$index]['text_en'] = $this->blockValue($page, "campus.feature.{$index}", 'en', 'summary', $fallbacks[$index]['text_en']);
        }

        return $fallbacks;
    }

    private function stories(Page $page): array
    {
        $fallbacks = $this->storyFallbacks();

        foreach (self::STORIES as $index) {
            $fallbacks[$index]['eyebrow_es'] = $this->blockValue($page, "campus.story.{$index}", 'es', 'subtitle', $fallbacks[$index]['eyebrow_es']);
            $fallbacks[$index]['eyebrow_en'] = $this->blockValue($page, "campus.story.{$index}", 'en', 'subtitle', $fallbacks[$index]['eyebrow_en']);
            $fallbacks[$index]['title_es'] = $this->blockValue($page, "campus.story.{$index}", 'es', 'title', $fallbacks[$index]['title_es']);
            $fallbacks[$index]['title_en'] = $this->blockValue($page, "campus.story.{$index}", 'en', 'title', $fallbacks[$index]['title_en']);
            $fallbacks[$index]['text_es'] = $this->blockValue($page, "campus.story.{$index}", 'es', 'summary', $fallbacks[$index]['text_es']);
            $fallbacks[$index]['text_en'] = $this->blockValue($page, "campus.story.{$index}", 'en', 'summary', $fallbacks[$index]['text_en']);
            $fallbacks[$index]['button_es'] = $this->blockValue($page, "campus.story.{$index}", 'es', 'cta_label', $fallbacks[$index]['button_es'] ?? '');
            $fallbacks[$index]['button_en'] = $this->blockValue($page, "campus.story.{$index}", 'en', 'cta_label', $fallbacks[$index]['button_en'] ?? '');
            $fallbacks[$index]['url'] = $this->blockData($page, "campus.story.{$index}", 'url', $fallbacks[$index]['url']);
        }

        return $fallbacks;
    }

    private function storyFallbacks(): array
    {
        return [
            1 => ['label' => 'Bibliotecas', 'eyebrow_es' => 'Características de la universidad', 'eyebrow_en' => 'University character', 'title_es' => 'Bibliotecas y espacios de aprendizaje', 'title_en' => 'Libraries and learning spaces', 'text_es' => 'Facilita el acceso a libros, tesis, artículos científicos y publicaciones académicas de sus facultades y centros de investigación, promoviendo la consulta, difusión y acceso al conocimiento académico y científico de la comunidad universitaria.', 'text_en' => 'Provides access to books, theses, scientific articles and academic publications from its faculties and research centers, promoting the consultation, dissemination and access to academic and scientific knowledge for the university community.', 'button_es' => '', 'button_en' => '', 'url' => 'http://bibliotecas.umss.edu.bo/site/php/index.php', 'image_url' => '/images/campus-life/library.png'],
            2 => ['label' => 'Facultades', 'eyebrow_es' => 'Fortalezas', 'eyebrow_en' => 'Strengths', 'title_es' => 'Facultades y carreras', 'title_en' => 'Faculties and careers', 'text_es' => 'La UMSS cuenta con una amplia diversidad de facultades que abarcan distintas áreas del conocimiento, ofreciendo formación académica en ciencias, tecnología, salud, humanidades, ciencias sociales y otras disciplinas. Esta variedad fortalece una comunidad universitaria multidisciplinaria y diversa.', 'text_en' => 'UMSS has a wide diversity of faculties covering different areas of knowledge, offering academic training in sciences, technology, health, humanities, social sciences and other disciplines. This variety strengthens a multidisciplinary and diverse university community.', 'button_es' => '', 'button_en' => '', 'url' => 'https://www.umss.edu.bo/facultades/', 'image_url' => '/images/campus-life/faculties.png'],
            3 => ['label' => 'Museo', 'eyebrow_es' => 'Historia', 'eyebrow_en' => 'History', 'title_es' => 'INIAM Museo UMSS', 'title_en' => 'INIAM UMSS Museum', 'text_es' => 'Fundado en 1951 como Museo Arqueológico y Etnográfico de la UMSS, dio origen en 1963 a la primera Escuela de Antropología y Arqueología de Bolivia. En 1980 fue consolidado como el Instituto de Investigaciones Antropológicas y Museo Arqueológico (INIAM-UMSS).', 'text_en' => "Founded in 1951 as the Archaeological and Ethnographic Museum of UMSS, it gave rise in 1963 to Bolivia's first School of Anthropology and Archaeology. In 1980, it was consolidated as the Institute of Anthropological Research and Archaeological Museum (INIAM-UMSS).", 'button_es' => '', 'button_en' => '', 'url' => 'https://museo.umss.edu.bo/', 'image_url' => '/images/campus-life/uni-view.png'],
            4 => ['label' => 'Cochabamba', 'eyebrow_es' => 'Recorriendo Cochabamba', 'eyebrow_en' => 'Getting around', 'title_es' => 'Más allá del campus', 'title_en' => 'Beyond campus', 'text_es' => 'La vida universitaria también se conecta con Cochabamba: su centro histórico, cultura, gastronomía, paisajes y espacios públicos.', 'text_en' => 'Campus life is also connected to Cochabamba: its historic center, culture, gastronomy, landscapes and public spaces.', 'button_es' => 'Explorar Cochabamba', 'button_en' => 'Explore Cochabamba', 'url' => 'https://visita.cochabamba.bo/', 'image_url' => '/images/campus-life/cochabamba.png'],
        ];
    }

    private function storyLabels(): array
    {
        return collect($this->storyFallbacks())->map(fn ($item) => $item['label'])->all();
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
            ['block_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'data' => $data, 'media_asset_id' => null]
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

    private function blockData(Page $page, string $key, string $dataKey, string $fallback): string
    {
        $value = $this->block($page, $key)?->data[$dataKey] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : $fallback;
    }

    private function featureIcon(int $index): string
    {
        return [1 => 'school', 2 => 'groups', 3 => 'public'][$index] ?? 'public';
    }

    private function authorizeCampusAccess(Page $page): void
    {
        abort_unless($page->slug === 'campus-life', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
