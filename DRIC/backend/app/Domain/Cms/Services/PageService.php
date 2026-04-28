<?php

namespace App\Domain\Cms\Services;

use App\Models\Page;

class PageService
{
    public function getPublishedPageBySlug(string $slug, string $locale): ?Page
    {
        return Page::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'translations',
                'seo',
                'sections.translations',
                'sections.contentBlocks.translations',
            ])
            ->first();
    }
}