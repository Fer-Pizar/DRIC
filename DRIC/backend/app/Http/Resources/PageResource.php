<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->query('locale', 'es');

        $translation = $this->translations
            ? $this->translations->firstWhere('language.code', $locale)
            : null;

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'page_type' => $this->page_type,
            'status' => $this->status,
            'title' => $translation?->title,
            'menu_label' => $translation?->menu_label,
            'summary' => $translation?->summary,
            'seo' => [
                'meta_title' => $this->seo?->meta_title,
                'meta_description' => $this->seo?->meta_description,
                'canonical_url' => $this->seo?->canonical_url,
            ],
            'sections' => SectionResource::collection($this->whenLoaded('sections')),
        ];
    }
}