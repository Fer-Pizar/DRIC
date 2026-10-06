<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const DEFAULT_FOOTER_SETTINGS = [
        'footer_title' => 'Dirección de Relaciones Internacionales y Convenios',
        'footer_address_line_1' => 'Av. Ballivián N. 591 esq. Reza, Cochabamba, Bolivia',
        'footer_address_line_2' => 'Edif. Mariscal Andrés de Santa Cruz',
        'footer_umss_url' => 'https://www.umss.edu.bo/',
        'footer_social_linkedin_url' => 'https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-image',
        'footer_social_facebook_url' => 'https://www.facebook.com/UMSS.DRIC',
        'footer_social_x_url' => 'https://x.com/UmssBolOficial',
        'footer_social_instagram_url' => 'https://www.instagram.com/umss.dric/',
        'footer_social_youtube_url' => 'https://www.youtube.com/c/UniversidadMayordeSanSimonOficial',
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
}
