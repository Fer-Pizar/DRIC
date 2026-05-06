<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $locale = $request->query('locale', 'es');

        $page = Page::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'translations.language',
                'seo',
                'sections' => fn ($query) => $query->orderBy('sort_order'),
                'sections.translations.language',
                'sections.contentBlocks' => fn ($query) => $query->orderBy('sort_order'),
                'sections.contentBlocks.translations.language',
            ])
            ->firstOrFail();

        return new PageResource($page);
    }
}