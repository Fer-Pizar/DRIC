<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug, $locale)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'translations',
                'sections' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                },
                'sections.translations',
                'sections.contentBlocks' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                },
                'sections.contentBlocks.translations',
            ])
            ->first();

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json($page);
    }
}