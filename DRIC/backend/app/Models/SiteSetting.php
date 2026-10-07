<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const DEFAULT_FOOTER_SETTINGS = [
        'footer_title' => 'Dirección de Relaciones Internacionales y Convenios',
        'footer_title_en' => 'Office of International Relations and Agreements',
        'footer_address_line_1' => 'Av. Ballivián N. 591 esq. Reza, Cochabamba, Bolivia',
        'footer_address_line_1_en' => 'Ballivián Ave. No. 591 at Reza, Cochabamba, Bolivia',
        'footer_address_line_2' => 'Edif. Mariscal Andrés de Santa Cruz',
        'footer_address_line_2_en' => 'Mariscal Andrés de Santa Cruz Building',
        'footer_umss_url' => 'https://www.umss.edu.bo/',
        'footer_social_linkedin_url' => 'https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-image',
        'footer_social_facebook_url' => 'https://www.facebook.com/UMSS.DRIC',
        'footer_social_x_url' => 'https://x.com/UmssBolOficial',
        'footer_social_instagram_url' => 'https://www.instagram.com/umss.dric/',
        'footer_social_youtube_url' => 'https://www.youtube.com/c/UniversidadMayordeSanSimonOficial',
    ];

    public const DEFAULT_MOBILE_MENU_SETTINGS = [
        'es' => [
            'kicker' => 'Explora DRIC',
            'title' => 'UMSS Global',
            'copy' => 'Navega por información institucional, convenios, proyectos, becas, informes, vida universitaria, verificación de certificados y canales de contacto.',
            'footer' => 'Universidad Mayor de San Simón · DRIC',
            'items' => [
                ['label' => 'Inicio', 'description' => 'Página principal', 'href' => 'inicio'],
                ['label' => 'Presentación', 'description' => 'Historia, misión y estructura', 'href' => 'presentacion'],
                ['label' => 'Convenios', 'description' => 'Relaciones institucionales', 'href' => 'convenios'],
                ['label' => 'Proyectos', 'description' => 'Cooperación y financiamiento', 'href' => 'proyectos'],
                ['label' => 'Becas y Movilidad', 'description' => 'Oportunidades internacionales', 'href' => 'becas-movilidad'],
                ['label' => 'Membresías', 'description' => 'Redes académicas globales', 'href' => 'membresias'],
                ['label' => 'Noticias', 'description' => 'Actualidad institucional', 'href' => 'noticias'],
                ['label' => 'Normativas', 'description' => 'Documentos y normativa', 'href' => 'normativas'],
                ['label' => 'Informes de Gestión', 'description' => 'Archivo institucional', 'href' => 'informes-gestion'],
                ['label' => 'Campus Life', 'description' => 'Vida universitaria UMSS', 'href' => 'campus-life'],
                ['label' => 'Verificar Certificado', 'description' => 'Validación institucional', 'href' => 'validar-certificado'],
                ['label' => 'Contacto', 'description' => 'Ubicación y canales', 'href' => 'contacto'],
            ],
        ],
        'en' => [
            'kicker' => 'Explore DRIC',
            'title' => 'Global UMSS',
            'copy' => 'Navigate through institutional information, agreements, projects, scholarships, reports, campus life, certificate verification and contact channels.',
            'footer' => 'Universidad Mayor de San Simón · DRIC',
            'items' => [
                ['label' => 'Home', 'description' => 'Main page', 'href' => 'inicio'],
                ['label' => 'Presentation', 'description' => 'History, mission and structure', 'href' => 'presentacion'],
                ['label' => 'Agreements', 'description' => 'Institutional relations', 'href' => 'convenios'],
                ['label' => 'Projects', 'description' => 'Cooperation and funding', 'href' => 'proyectos'],
                ['label' => 'Scholarships and Mobility', 'description' => 'International opportunities', 'href' => 'becas-movilidad'],
                ['label' => 'Memberships', 'description' => 'Global academic networks', 'href' => 'membresias'],
                ['label' => 'News', 'description' => 'Institutional updates', 'href' => 'noticias'],
                ['label' => 'Regulations', 'description' => 'Documents and regulations', 'href' => 'normativas'],
                ['label' => 'Management Reports', 'description' => 'Institutional archive', 'href' => 'informes-gestion'],
                ['label' => 'Campus Life', 'description' => 'UMSS university life', 'href' => 'campus-life'],
                ['label' => 'Verify Certificate', 'description' => 'Institutional validation', 'href' => 'validar-certificado'],
                ['label' => 'Contact', 'description' => 'Location and channels', 'href' => 'contacto'],
            ],
        ],
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    public static function value(string $key, ?string $default = null): ?string
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, ?string $value): self
    {
        return static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );
    }

    public static function footerSettings(): array
    {
        $stored = static::query()
            ->whereIn('key', array_keys(self::DEFAULT_FOOTER_SETTINGS))
            ->pluck('value', 'key')
            ->all();

        return array_replace(self::DEFAULT_FOOTER_SETTINGS, $stored);
    }

    public static function mobileMenuSettings(): array
    {
        $stored = static::value('mobile_menu_settings');

        if (! $stored) {
            return self::DEFAULT_MOBILE_MENU_SETTINGS;
        }

        $decoded = json_decode($stored, true);

        if (! is_array($decoded)) {
            return self::DEFAULT_MOBILE_MENU_SETTINGS;
        }

        return array_replace_recursive(self::DEFAULT_MOBILE_MENU_SETTINGS, $decoded);
    }
}
