<?php

namespace App\Support;

class NewsStaticContent
{
    private static ?array $content = null;

    public static function article(string $slug): ?array
    {
        return collect(self::all()['articles'])
            ->first(fn (array $article) => ($article['id'] ?? null) === $slug);
    }

    public static function all(): array
    {
        if (self::$content !== null) {
            return self::$content;
        }

        $path = database_path('data/news_details.json');

        if (! is_file($path)) {
            return self::$content = ['articles' => []];
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return self::$content = is_array($decoded)
            ? ['articles' => is_array($decoded['articles'] ?? null) ? $decoded['articles'] : []]
            : ['articles' => []];
    }
}
