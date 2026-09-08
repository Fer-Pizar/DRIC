<?php

namespace App\Support;

class NationalForeignInfoStaticContent
{
    private static ?array $content = null;

    public static function all(): array
    {
        if (self::$content !== null) {
            return self::$content;
        }

        $path = database_path('data/national_foreign_info.json');

        if (! is_file($path)) {
            return self::$content = ['copy' => [], 'sections' => []];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return self::$content = is_array($decoded)
            ? [
                'copy' => is_array($decoded['copy'] ?? null) ? $decoded['copy'] : [],
                'sections' => is_array($decoded['sections'] ?? null) ? $decoded['sections'] : [],
            ]
            : ['copy' => [], 'sections' => []];
    }
}
