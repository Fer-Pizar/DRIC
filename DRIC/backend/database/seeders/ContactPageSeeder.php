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

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'contacto'],
            ['page_type' => 'static', 'status' => 'published', 'published_at' => now(), 'sort_order' => 12]
        );

        $languages = Language::query()->whereIn('code', ['es', 'en'])->get()->keyBy('code');

        foreach ($this->pageTranslations() as $locale => $values) {
            PageTranslation::updateOrCreate(
                ['page_id' => $page->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }

        $this->section($page, 'contact.hero', 'contact_hero', 1, $languages, [
            'es' => ['title' => 'Contacto', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Comunícate con la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.', 'body' => null],
            'en' => ['title' => 'Contact DRIC', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Get in touch with the Directorate of International Relations and Agreements of Universidad Mayor de San Simón.', 'body' => null],
        ]);

        $this->section($page, 'contact.phone', 'contact_card', 2, $languages, [
            'es' => ['title' => 'Teléfonos', 'subtitle' => null, 'summary' => '(+591) 4 4524779', 'body' => null],
            'en' => ['title' => 'Phone', 'subtitle' => null, 'summary' => '(+591) 4 4524779', 'body' => null],
        ]);

        $this->section($page, 'contact.email', 'contact_card', 3, $languages, [
            'es' => ['title' => 'Correo electrónico', 'subtitle' => null, 'summary' => 'rrii@umss.edu.bo', 'body' => null],
            'en' => ['title' => 'Email', 'subtitle' => null, 'summary' => 'rrii@umss.edu.bo', 'body' => null],
        ]);

        $this->section($page, 'contact.address', 'contact_card', 4, $languages, [
            'es' => ['title' => 'Dirección', 'subtitle' => 'DRIC', 'summary' => 'Av. Ballivián N. 591 esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezanine, Cochabamba, Bolivia.', 'body' => null],
            'en' => ['title' => 'Address', 'subtitle' => 'DRIC', 'summary' => 'Av. Ballivián N. 591 Esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezzanine, Cochabamba, Bolivia.', 'body' => null],
        ]);

        $social = $this->section($page, 'contact.social', 'contact_social_links', 5, $languages, [
            'es' => ['title' => 'Canales institucionales', 'subtitle' => null, 'summary' => 'Redes sociales oficiales para conocer novedades, convocatorias y actividades institucionales.', 'body' => null],
            'en' => ['title' => 'Institutional channels', 'subtitle' => null, 'summary' => 'Official social networks for news, calls and institutional activities.', 'body' => null],
        ]);

        if (ContentBlock::query()->where('section_id', $social->id)->exists()) {
            return;
        }

        foreach ($this->socialLinks() as $index => $link) {
            $block = ContentBlock::create([
                'section_id' => $social->id,
                'link_url' => 'contact.social.'.$link['key'],
                'block_type' => 'contact_social_link',
                'sort_order' => $index + 1,
                'is_active' => true,
                'data' => ['url' => $link['url']],
            ]);

            foreach (['es', 'en'] as $locale) {
                ContentBlockTranslation::updateOrCreate(
                    ['content_block_id' => $block->id, 'language_id' => $languages[$locale]->id],
                    [
                        'title' => $link['label'][$locale],
                        'subtitle' => null,
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
            'es' => ['title' => 'Contacto', 'menu_title' => 'Contacto', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Comunícate con la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.', 'body' => null],
            'en' => ['title' => 'Contact DRIC', 'menu_title' => 'Contact', 'subtitle' => 'DRIC · UMSS', 'summary' => 'Get in touch with the Directorate of International Relations and Agreements of Universidad Mayor de San Simón.', 'body' => null],
        ];
    }

    private function socialLinks(): array
    {
        return [
            ['key' => 'linkedin', 'label' => ['es' => 'LinkedIn', 'en' => 'LinkedIn'], 'url' => 'https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-image'],
            ['key' => 'facebook', 'label' => ['es' => 'Facebook', 'en' => 'Facebook'], 'url' => 'https://www.facebook.com/UMSS.DRIC'],
            ['key' => 'x', 'label' => ['es' => 'X', 'en' => 'X'], 'url' => 'https://x.com/UmssBolOficial'],
            ['key' => 'instagram', 'label' => ['es' => 'Instagram', 'en' => 'Instagram'], 'url' => 'https://www.instagram.com/umss.dric/'],
            ['key' => 'youtube', 'label' => ['es' => 'YouTube', 'en' => 'YouTube'], 'url' => 'https://www.youtube.com/c/UniversidadMayordeSanSimonOficial'],
        ];
    }

    private function section(Page $page, string $key, string $type, int $sortOrder, $languages, array $translations): Section
    {
        $section = Section::updateOrCreate(
            ['page_id' => $page->id, 'section_key' => $key],
            ['section_type' => $type, 'sort_order' => $sortOrder, 'is_active' => true, 'settings' => ['editable' => true]]
        );

        foreach ($translations as $locale => $values) {
            SectionTranslation::updateOrCreate(
                ['section_id' => $section->id, 'language_id' => $languages[$locale]->id],
                $values
            );
        }

        return $section;
    }
}
