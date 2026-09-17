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
use Illuminate\View\View;

class PresentationContentController extends Controller
{
    private const MAX_IMAGE_KB = 3072;
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizePresentationAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
            'sections.contentBlocks.mediaAsset.translations.language',
        ]);

        return view('admin.pages.presentation-content', [
            'page' => $page,
            'content' => $this->formContent($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizePresentationAccess($page);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages(), $this->attributes());

        $validator->after(function ($validator) use ($request): void {
            foreach ($this->lines((string) $request->input('director_emails', '')) as $email) {
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validator->errors()->add('director_emails', "El correo '{$email}' no tiene un formato válido.");
                }
            }
        });

        $validated = $validator->validate();

        DB::transaction(function () use ($request, $validated, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

            foreach (['es', 'en'] as $locale) {
                $language = $languages[$locale];

                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $language->id],
                    [
                        'title' => $validated[$locale]['hero_title'],
                        'menu_title' => $validated[$locale]['hero_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['hero_summary'],
                        'body' => null,
                    ]
                );
            }

            $history = $this->upsertSection($page, 'presentation.history', 'presentation_history', 1);
            $missionPurpose = $this->upsertSection($page, 'presentation.mission-purpose', 'mission_purpose', 2);
            $structure = $this->upsertSection($page, 'presentation.structure', 'organization_structure', 3);

            foreach (['es', 'en'] as $locale) {
                $language = $languages[$locale];

                SectionTranslation::updateOrCreate(
                    ['section_id' => $history->id, 'language_id' => $language->id],
                    [
                        'title' => $validated[$locale]['history_title'],
                        'subtitle' => $validated[$locale]['history_badge'],
                        'summary' => $validated[$locale]['history_text'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $structure->id, 'language_id' => $language->id],
                    [
                        'title' => $validated[$locale]['structure_title'],
                        'subtitle' => $validated[$locale]['structure_badge'],
                        'summary' => $validated[$locale]['structure_description'],
                        'body' => null,
                    ]
                );
            }

            $this->upsertBlock($missionPurpose, 'presentation.mission', 'mission', 1, $languages, [
                'es' => ['title' => $validated['es']['mission_title'], 'summary' => $validated['es']['mission_text']],
                'en' => ['title' => $validated['en']['mission_title'], 'summary' => $validated['en']['mission_text']],
            ]);

            $this->upsertBlock($missionPurpose, 'presentation.purpose', 'purpose', 2, $languages, [
                'es' => ['title' => $validated['es']['purpose_title'], 'summary' => $validated['es']['purpose_text']],
                'en' => ['title' => $validated['en']['purpose_title'], 'summary' => $validated['en']['purpose_text']],
            ]);

            $this->upsertBlock($structure, 'presentation.structure-items', 'structure_items', 1, $languages, [
                'es' => ['title' => 'Áreas de la estructura', 'summary' => null],
                'en' => ['title' => 'Structure areas', 'summary' => null],
            ], [
                'items_es' => $this->lines($validated['es']['structure_items']),
                'items_en' => $this->lines($validated['en']['structure_items']),
            ]);

            $this->upsertBlock($structure, 'presentation.director', 'director', 2, $languages, [
                'es' => ['title' => $validated['es']['director_name'], 'summary' => null],
                'en' => ['title' => $validated['en']['director_name'], 'summary' => null],
            ], [
                'emails' => $this->lines($validated['director_emails']),
            ]);

            $this->upsertBlock($structure, 'presentation.agreements-team', 'staff_group', 3, $languages, [
                'es' => ['title' => $validated['es']['agreements_team_title'], 'summary' => null],
                'en' => ['title' => $validated['en']['agreements_team_title'], 'summary' => null],
            ], [
                'people_es' => $this->lines($validated['es']['agreements_team_people']),
                'people_en' => $this->lines($validated['en']['agreements_team_people']),
            ]);

            $this->upsertBlock($structure, 'presentation.projects-team', 'staff_group', 4, $languages, [
                'es' => ['title' => $validated['es']['projects_team_title'], 'summary' => null],
                'en' => ['title' => $validated['en']['projects_team_title'], 'summary' => null],
            ], [
                'people_es' => $this->lines($validated['es']['projects_team_people']),
                'people_en' => $this->lines($validated['en']['projects_team_people']),
            ]);

            $historyImage = $this->upsertBlock($history, 'presentation.history-image', 'image', 1, $languages, [
                'es' => ['title' => 'Imagen del equipo DRIC', 'summary' => null],
                'en' => ['title' => 'DRIC team image', 'summary' => null],
            ]);

            $directorImage = $this->upsertBlock($structure, 'presentation.director-image', 'image', 5, $languages, [
                'es' => ['title' => 'Imagen del director', 'summary' => null],
                'en' => ['title' => 'Director image', 'summary' => null],
            ]);

            if ($request->hasFile('team_image')) {
                $historyImage->update([
                    'media_asset_id' => $this->storeImage($request, 'team_image', 'presentation/equipo')->id,
                ]);
            }

            if ($request->hasFile('director_image')) {
                $directorImage->update([
                    'media_asset_id' => $this->storeImage($request, 'director_image', 'presentation/director')->id,
                ]);
            }
        });

        return redirect()
            ->route('admin.pages.presentation.edit', $page)
            ->with('success', 'El contenido de Presentación fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $localized = [];

        foreach (['es', 'en'] as $locale) {
            $localized["{$locale}.hero_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.hero_summary"] = ['required', 'string', 'max:600'];
            $localized["{$locale}.history_badge"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.history_title"] = ['required', 'string', 'max:180', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.history_text"] = ['required', 'string', 'max:1800'];
            $localized["{$locale}.mission_title"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.mission_text"] = ['required', 'string', 'max:1800'];
            $localized["{$locale}.purpose_title"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.purpose_text"] = ['required', 'string', 'max:1800'];
            $localized["{$locale}.structure_badge"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.structure_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.structure_description"] = ['required', 'string', 'max:1200'];
            $localized["{$locale}.structure_items"] = ['required', 'string', 'max:1000'];
            $localized["{$locale}.director_name"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.agreements_team_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.agreements_team_people"] = ['required', 'string', 'max:1000'];
            $localized["{$locale}.projects_team_title"] = ['required', 'string', 'max:160', 'regex:'.self::CLEAN_LABEL_REGEX];
            $localized["{$locale}.projects_team_people"] = ['required', 'string', 'max:1000'];
        }

        return array_merge($localized, [
            'director_emails' => ['required', 'string', 'max:500'],
            'team_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
            'director_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:'.self::MAX_IMAGE_KB],
        ]);
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
            'file' => 'Debes subir un archivo válido.',
            'mimes' => 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.',
            'team_image.max' => 'La imagen del equipo es demasiado pesada. El tamaño máximo permitido es 3 MB.',
            'director_image.max' => 'La imagen del director es demasiado pesada. El tamaño máximo permitido es 3 MB.',
        ];
    }

    private function attributes(): array
    {
        return [
            'team_image' => 'imagen del equipo',
            'director_image' => 'imagen del director',
        ];
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'hero_title' => $this->pageValue($page, 'es', 'title', 'Presentación'),
                'hero_summary' => $this->pageValue($page, 'es', 'summary', 'La Dirección de Relaciones Internacionales y Convenios promueve la cooperación, movilidad, proyectos y oportunidades académicas internacionales de la Universidad Mayor de San Simón.'),
                'history_badge' => $this->sectionValue($page, 'presentation.history', 'es', 'subtitle', 'Historia institucional'),
                'history_title' => $this->sectionValue($page, 'presentation.history', 'es', 'title', 'Una visión internacional desde la UMSS'),
                'history_text' => $this->sectionValue($page, 'presentation.history', 'es', 'summary', 'La Dirección de Relaciones Internacionales y Convenios fue creada el 7 de enero de 1988, con el rango de Secretaría. El año 1995 se instituye como Departamento y en noviembre de 1997 se crea la actual Dirección.'),
                'mission_title' => $this->blockValue($page, 'presentation.mission', 'es', 'title', 'Misión'),
                'mission_text' => $this->blockValue($page, 'presentation.mission', 'es', 'summary', 'Promover, coordinar y canalizar la cooperación internacional y nacional, así como la coordinación interinstitucional de la UMSS, en beneficio de los procesos de enseñanza-aprendizaje, investigación científica y tecnológica, interacción social y fortalecimiento institucional.'),
                'purpose_title' => $this->blockValue($page, 'presentation.purpose', 'es', 'title', 'Propósito'),
                'purpose_text' => $this->blockValue($page, 'presentation.purpose', 'es', 'summary', 'Es propósito fundamental de la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón explorar de manera organizada y sistemática las oportunidades de cooperación internacional y de coordinación interinstitucional.'),
                'structure_badge' => $this->sectionValue($page, 'presentation.structure', 'es', 'subtitle', 'Estructura'),
                'structure_title' => $this->sectionValue($page, 'presentation.structure', 'es', 'title', 'Dirección DRIC'),
                'structure_description' => $this->sectionValue($page, 'presentation.structure', 'es', 'summary', 'La DRIC depende directamente del Rectorado. Para el cumplimiento de sus funciones, se estructura de la siguiente manera:'),
                'structure_items' => $this->blockLines($page, 'presentation.structure-items', 'items_es', ['Dirección Ejecutiva', 'Departamento de Convenios, Movilidad y Becas', 'Departamento de Internacionalización y Proyectos']),
                'director_name' => $this->blockValue($page, 'presentation.director', 'es', 'title', 'Director, Mgr. Omar Morales Delgadillo'),
                'agreements_team_title' => $this->blockValue($page, 'presentation.agreements-team', 'es', 'title', 'Convenios, Movilidad y Becas'),
                'agreements_team_people' => $this->blockLines($page, 'presentation.agreements-team', 'people_es', ['Jefe del departamento: Mgr. Giovanna Maldonado Moscoso', 'Mgr. Silvia del Pilar Arze']),
                'projects_team_title' => $this->blockValue($page, 'presentation.projects-team', 'es', 'title', 'Internacionalización y Proyectos'),
                'projects_team_people' => $this->blockLines($page, 'presentation.projects-team', 'people_es', ['Jefe del Departamento: Mgr. Daniel Vasquez Torrez', 'Ing. John Medina']),
            ],
            'en' => [
                'hero_title' => $this->pageValue($page, 'en', 'title', 'About DRIC'),
                'hero_summary' => $this->pageValue($page, 'en', 'summary', 'The Directorate of International Relations and Agreements promotes cooperation, mobility, projects and international academic opportunities for Universidad Mayor de San Simón.'),
                'history_badge' => $this->sectionValue($page, 'presentation.history', 'en', 'subtitle', 'Institutional history'),
                'history_title' => $this->sectionValue($page, 'presentation.history', 'en', 'title', 'International vision from UMSS'),
                'history_text' => $this->sectionValue($page, 'presentation.history', 'en', 'summary', 'The Directorate of International Relations and Agreements was created on January 7, 1988, with the rank of Secretariat. In 1995 it was established as a Department, and in November 1997 the current Directorate was created.'),
                'mission_title' => $this->blockValue($page, 'presentation.mission', 'en', 'title', 'Mission'),
                'mission_text' => $this->blockValue($page, 'presentation.mission', 'en', 'summary', 'To promote, coordinate and channel international and national cooperation, as well as UMSS interinstitutional coordination, in support of teaching and learning processes, scientific and technological research, social engagement and institutional strengthening.'),
                'purpose_title' => $this->blockValue($page, 'presentation.purpose', 'en', 'title', 'Purpose'),
                'purpose_text' => $this->blockValue($page, 'presentation.purpose', 'en', 'summary', 'The main purpose of the Directorate of International Relations and Agreements of Universidad Mayor de San Simón is to explore international cooperation and interinstitutional coordination opportunities in an organized and systematic way.'),
                'structure_badge' => $this->sectionValue($page, 'presentation.structure', 'en', 'subtitle', 'Organizational structure'),
                'structure_title' => $this->sectionValue($page, 'presentation.structure', 'en', 'title', 'DRIC Directorate'),
                'structure_description' => $this->sectionValue($page, 'presentation.structure', 'en', 'summary', 'DRIC reports directly to the Rector\'s Office. To fulfill its functions, it is structured as follows:'),
                'structure_items' => $this->blockLines($page, 'presentation.structure-items', 'items_en', ['Executive Directorate', 'Department of Agreements, Mobility and Scholarships', 'Department of Internationalization and Projects']),
                'director_name' => $this->blockValue($page, 'presentation.director', 'en', 'title', 'Director, Mgr. Omar Morales Delgadillo'),
                'agreements_team_title' => $this->blockValue($page, 'presentation.agreements-team', 'en', 'title', 'Agreements, Mobility and Scholarships'),
                'agreements_team_people' => $this->blockLines($page, 'presentation.agreements-team', 'people_en', ['Head of Department: Mgr. Giovanna Maldonado Moscoso', 'Mgr. Silvia del Pilar Arze']),
                'projects_team_title' => $this->blockValue($page, 'presentation.projects-team', 'en', 'title', 'Internationalization and Projects'),
                'projects_team_people' => $this->blockLines($page, 'presentation.projects-team', 'people_en', ['Head of Department: Mgr. Daniel Vasquez Torrez', 'Eng. John Medina']),
            ],
            'director_emails' => $this->blockLines($page, 'presentation.director', 'emails', ['director-dric@umss.edu.bo', 'rrii@umss.edu.bo']),
            'team_image_url' => $this->blockImageUrl($page, 'presentation.history-image'),
            'director_image_url' => $this->blockImageUrl($page, 'presentation.director-image'),
        ];
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            [
                'section_type' => $type,
                'sort_order' => $sortOrder,
                'is_active' => true,
                'settings' => ['editable' => true],
            ]
        );
    }

    private function upsertBlock(Section $section, string $key, string $type, int $sortOrder, $languages, array $translations, array $data = []): ContentBlock
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

        foreach (['es', 'en'] as $locale) {
            ContentBlockTranslation::updateOrCreate(
                ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                [
                    'title' => $translations[$locale]['title'],
                    'summary' => $translations[$locale]['summary'],
                    'subtitle' => null,
                    'body' => null,
                ]
            );
        }

        return $block;
    }

    private function storeImage(Request $request, string $field, string $prefix): MediaAsset
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

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get();

        foreach ($languages as $language) {
            MediaTranslation::updateOrCreate(
                ['media_asset_id' => $media->id, 'language_id' => $language->id],
                [
                    'alt_text' => $field === 'team_image' ? 'Equipo DRIC UMSS' : 'Director DRIC',
                    'caption' => null,
                ]
            );
        }

        return $media;
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        $section = $page->sections->firstWhere('section_key', $key);

        return $section?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        $block = $this->block($page, $key);

        return $block?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function blockLines(Page $page, string $key, string $dataKey, array $fallback): string
    {
        $lines = $this->block($page, $key)?->data[$dataKey] ?? $fallback;

        return implode("\n", is_array($lines) ? $lines : $fallback);
    }

    private function blockImageUrl(Page $page, string $key): ?string
    {
        $media = $this->block($page, $key)?->mediaAsset;

        if (! $media?->file_path) {
            return null;
        }

        return '/storage/'.ltrim($media->file_path, '/');
    }

    private function block(Page $page, string $key): ?ContentBlock
    {
        return $page->sections
            ->flatMap(fn (Section $section) => $section->contentBlocks)
            ->firstWhere('link_url', $key);
    }

    private function lines(string $value): array
    {
        return collect(preg_split('/\R/', $value) ?: [])
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    private function authorizePresentationAccess(Page $page): void
    {
        abort_unless($page->slug === 'presentacion', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
