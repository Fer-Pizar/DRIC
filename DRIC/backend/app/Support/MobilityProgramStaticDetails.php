<?php

namespace App\Support;

class MobilityProgramStaticDetails
{
    private static ?array $details = null;

    public static function forSlug(?string $slug): array
    {
        if (! $slug) {
            return [];
        }

        return self::all()[$slug] ?? [];
    }

    private static function all(): array
    {
        if (self::$details !== null) {
            return self::$details;
        }

        $path = database_path('data/mobility_pasantias_details.json');

        if (! is_file($path)) {
            return self::$details = [];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return self::$details = is_array($decoded) ? $decoded : [];
    }
}
