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

class ContactContentController extends Controller
{
    private const CLEAN_LABEL_REGEX = '/\A[\p{L}\s.,]+\z/u';

    public function edit(Page $page): View
    {
        $this->authorizeContactAccess($page);

        $page->load([
            'translations.language',
            'sections.translations.language',
            'sections.contentBlocks.translations.language',
        ]);

        return view('admin.pages.contact-content', [
            'page' => $page,
            'content' => $this->formContent($page),
            'socialLinks' => $this->socialLinks($page),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $this->authorizeContactAccess($page);

        $validated = Validator::make($request->all(), $this->rules(), $this->messages())->validate();
        $socialLinks = $this->validatedSocialLinks($request);

        DB::transaction(function () use ($request, $validated, $socialLinks, $page): void {
            $page->update([
                'status' => 'published',
                'published_at' => $page->published_at ?? now(),
                'updated_by' => $request->user()->id,
            ]);

            $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

            $hero = $this->upsertSection($page, 'contact.hero', 'contact_hero', 1);
            $phone = $this->upsertSection($page, 'contact.phone', 'contact_card', 2);
            $email = $this->upsertSection($page, 'contact.email', 'contact_card', 3);
            $address = $this->upsertSection($page, 'contact.address', 'contact_card', 4);
            $social = $this->upsertSection($page, 'contact.social', 'contact_social_links', 5);

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
                    ['section_id' => $phone->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['phone_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['phone_value'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $email->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['email_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['email_value'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $address->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['address_title'],
                        'subtitle' => $validated[$locale]['address_name'],
                        'summary' => $validated[$locale]['address_text'],
                        'body' => null,
                    ]
                );

                SectionTranslation::updateOrCreate(
                    ['section_id' => $social->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $validated[$locale]['social_title'],
                        'subtitle' => null,
                        'summary' => $validated[$locale]['social_summary'],
                        'body' => null,
                    ]
                );
            }

            $this->syncSocialLinks($social, $socialLinks, $languages);
        });

        return redirect()
            ->route('admin.pages.contact.edit', $page)
            ->with('success', 'El contenido de Contacto fue actualizado correctamente.');
    }

    private function rules(): array
    {
        $rules = [];

        foreach (['es', 'en'] as $locale) {
            $rules["{$locale}.badge"] = ['required', 'string', 'max:80'];
            $rules["{$locale}.title"] = ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.intro"] = ['required', 'string', 'max:700'];
            $rules["{$locale}.phone_title"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.phone_value"] = ['required', 'string', 'max:80'];
            $rules["{$locale}.email_title"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.email_value"] = ['required', 'email', 'max:180'];
            $rules["{$locale}.address_title"] = ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.address_name"] = ['required', 'string', 'max:120', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.address_text"] = ['required', 'string', 'max:900'];
            $rules["{$locale}.social_title"] = ['required', 'string', 'max:140', 'regex:'.self::CLEAN_LABEL_REGEX];
            $rules["{$locale}.social_summary"] = ['required', 'string', 'max:500'];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => 'Este campo es obligatorio.',
            'string' => 'Este campo debe contener texto.',
            'email' => 'Ingresa un correo válido, por ejemplo: rrii@umss.edu.bo',
            'url' => 'Ingresa una URL completa y válida, por ejemplo: https://www.umss.edu.bo',
            'max' => 'Este campo supera el tamaño permitido.',
            'regex' => 'Este campo solo puede contener letras, espacios, puntos y comas. No uses números ni símbolos especiales.',
        ];
    }

    private function validatedSocialLinks(Request $request): array
    {
        $rows = collect($request->input('social_links', []))
            ->filter(fn ($row) => filled($row['label_es'] ?? null) || filled($row['label_en'] ?? null) || filled($row['url'] ?? null) || filled($row['id'] ?? null))
            ->values()
            ->all();

        $validator = Validator::make(
            ['social_links' => $rows],
            [
                'social_links' => ['array'],
                'social_links.*.id' => ['nullable', 'integer'],
                'social_links.*.label_es' => ['required', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX],
                'social_links.*.label_en' => ['nullable', 'string', 'max:80', 'regex:'.self::CLEAN_LABEL_REGEX],
                'social_links.*.url' => ['required', 'url', 'max:900'],
            ],
            [
                'social_links.*.label_es.required' => 'Escribe el nombre de la red social.',
                'social_links.*.label_es.regex' => 'El nombre de la red social solo puede contener letras, espacios, puntos y comas.',
                'social_links.*.label_en.regex' => 'El nombre en inglés solo puede contener letras, espacios, puntos y comas.',
                'social_links.*.url.required' => 'Escribe la URL de la red social.',
                'social_links.*.url.url' => 'Ingresa una URL completa y válida, por ejemplo: https://www.facebook.com/UMSS.DRIC',
            ]
        );

        $validated = $validator->validate();

        return collect($validated['social_links'] ?? [])
            ->map(fn ($row) => [
                'id' => isset($row['id']) ? (int) $row['id'] : null,
                'label_es' => trim($row['label_es']),
                'label_en' => trim($row['label_en'] ?? '') ?: trim($row['label_es']),
                'url' => trim($row['url']),
            ])
            ->all();
    }

    private function formContent(Page $page): array
    {
        return [
            'es' => [
                'badge' => $this->sectionValue($page, 'contact.hero', 'es', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'es', 'title', 'Contacto'),
                'intro' => $this->sectionValue($page, 'contact.hero', 'es', 'summary', 'Comunícate con la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.'),
                'phone_title' => $this->sectionValue($page, 'contact.phone', 'es', 'title', 'Teléfonos'),
                'phone_value' => $this->sectionValue($page, 'contact.phone', 'es', 'summary', '(+591) 4 4524779'),
                'email_title' => $this->sectionValue($page, 'contact.email', 'es', 'title', 'Correo electrónico'),
                'email_value' => $this->sectionValue($page, 'contact.email', 'es', 'summary', 'rrii@umss.edu.bo'),
                'address_title' => $this->sectionValue($page, 'contact.address', 'es', 'title', 'Dirección'),
                'address_name' => $this->sectionValue($page, 'contact.address', 'es', 'subtitle', 'DRIC'),
                'address_text' => $this->sectionValue($page, 'contact.address', 'es', 'summary', 'Av. Ballivián N. 591 esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezanine, Cochabamba, Bolivia.'),
                'social_title' => $this->sectionValue($page, 'contact.social', 'es', 'title', 'Canales institucionales'),
                'social_summary' => $this->sectionValue($page, 'contact.social', 'es', 'summary', 'Redes sociales oficiales para conocer novedades, convocatorias y actividades institucionales.'),
            ],
            'en' => [
                'badge' => $this->sectionValue($page, 'contact.hero', 'en', 'subtitle', 'DRIC · UMSS'),
                'title' => $this->pageValue($page, 'en', 'title', 'Contact DRIC'),
                'intro' => $this->sectionValue($page, 'contact.hero', 'en', 'summary', 'Get in touch with the Directorate of International Relations and Agreements of Universidad Mayor de San Simón.'),
                'phone_title' => $this->sectionValue($page, 'contact.phone', 'en', 'title', 'Phone'),
                'phone_value' => $this->sectionValue($page, 'contact.phone', 'en', 'summary', '(+591) 4 4524779'),
                'email_title' => $this->sectionValue($page, 'contact.email', 'en', 'title', 'Email'),
                'email_value' => $this->sectionValue($page, 'contact.email', 'en', 'summary', 'rrii@umss.edu.bo'),
                'address_title' => $this->sectionValue($page, 'contact.address', 'en', 'title', 'Address'),
                'address_name' => $this->sectionValue($page, 'contact.address', 'en', 'subtitle', 'DRIC'),
                'address_text' => $this->sectionValue($page, 'contact.address', 'en', 'summary', 'Av. Ballivián N. 591 Esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezzanine, Cochabamba, Bolivia.'),
                'social_title' => $this->sectionValue($page, 'contact.social', 'en', 'title', 'Institutional channels'),
                'social_summary' => $this->sectionValue($page, 'contact.social', 'en', 'summary', 'Official social networks for news, calls and institutional activities.'),
            ],
        ];
    }

    private function socialLinks(Page $page): array
    {
        $section = $page->sections->firstWhere('section_key', 'contact.social');

        return ($section?->contentBlocks ?? collect())
            ->where('is_active', true)
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ContentBlock $block) => [
                'id' => $block->id,
                'label_es' => $block->translations->firstWhere('language.code', 'es')?->title ?? '',
                'label_en' => $block->translations->firstWhere('language.code', 'en')?->title ?? '',
                'url' => is_string($block->data['url'] ?? null) ? $block->data['url'] : ($block->link_url ?? ''),
            ])
            ->all();
    }

    private function syncSocialLinks(Section $section, array $socialLinks, $languages): void
    {
        $keptIds = [];

        foreach ($socialLinks as $index => $socialLink) {
            $block = $socialLink['id']
                ? ContentBlock::query()->where('section_id', $section->id)->where('id', $socialLink['id'])->first()
                : null;

            if (! $block) {
                $block = new ContentBlock([
                    'section_id' => $section->id,
                    'link_url' => 'contact.social.'.Str::uuid()->toString(),
                ]);
            }

            $block->fill([
                'block_type' => 'contact_social_link',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => ['url' => $socialLink['url']],
            ]);
            $block->save();
            $keptIds[] = $block->id;

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $locale === 'es' ? $socialLink['label_es'] : $socialLink['label_en'],
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
    }

    private function upsertSection(Page $page, string $key, string $type, int $sortOrder): Section
    {
        return Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );
    }

    private function pageValue(Page $page, string $locale, string $field, string $fallback): string
    {
        return $page->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function sectionValue(Page $page, string $key, string $locale, string $field, string $fallback): string
    {
        return $page->sections->firstWhere('section_key', $key)?->translations->firstWhere('language.code', $locale)?->{$field} ?? $fallback;
    }

    private function authorizeContactAccess(Page $page): void
    {
        abort_unless($page->slug === 'contacto', 404);
        abort_unless(PagePermissionMap::canEditPage(auth()->user(), $page), 403, 'No tienes permiso para editar esta página.');
    }
}
