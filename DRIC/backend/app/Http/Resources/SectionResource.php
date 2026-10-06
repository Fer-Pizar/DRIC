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
            'section_key' => $this->section_key,
            'section_type' => $this->section_type,
            'layout' => $this->layout,
            'sort_order' => $this->sort_order,
            'is_active' => (bool) $this->is_active,
            'settings' => $this->normalizeFrontendImagePaths($this->settings ?? []),
            'title' => $translation?->title,
            'subtitle' => $translation?->subtitle,
            'summary' => $translation?->summary,
            'body' => $translation?->body,
            'blocks' => ContentBlockResource::collection($this->whenLoaded('contentBlocks')),
        ];
    }

    private function normalizeFrontendImagePaths(mixed $value): mixed
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => $this->normalizeFrontendImagePaths($item))
                ->all();
        }

        if (! is_string($value)) {
            return $value;
        }

        $decoded = rawurldecode($value);
        if (preg_match('~/admin/frontend-image/(images/.+)$~', $decoded, $matches)) {
            return '/'.$matches[1];
        }

        if (str_starts_with($decoded, 'admin/frontend-image/images/')) {
            return '/'.substr($decoded, strlen('admin/frontend-image/'));
        }

        return $value;
    }
}
