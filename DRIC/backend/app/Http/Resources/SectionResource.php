<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->query('locale', 'es');

        $translation = $this->translations
            ? $this->translations->firstWhere('language.code', $locale)
            : null;

        return [
            'id' => $this->id,
            'type' => $this->section_type ?? $this->layout,
            'layout' => $this->layout,
            'sort_order' => $this->sort_order,
            'settings' => $this->settings ?? [],
            'title' => $translation?->title,
            'subtitle' => $translation?->subtitle,
            'summary' => $translation?->summary,
            'body' => $translation?->body,
            'blocks' => ContentBlockResource::collection($this->whenLoaded('contentBlocks')),
        ];
    }
}