<?php

namespace App\Support;

class AwardsOpportunityStaticContent
{
    private static ?array $content = null;

    public static function all(): array
    {
        if (self::$content !== null) {
            return self::$content;
        }

        $path = database_path('data/awards_opportunities.json');

        if (! is_file($path)) {
            return self::$content = ['copy' => [], 'opportunities' => []];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return self::$content = is_array($decoded)
            ? [
                'copy' => is_array($decoded['copy'] ?? null) ? $decoded['copy'] : [],
                'opportunities' => is_array($decoded['opportunities'] ?? null) ? $decoded['opportunities'] : [],
            ]
            : ['copy' => [], 'opportunities' => []];
    }
}
