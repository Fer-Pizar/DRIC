<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentBlockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->query('locale', 'es');

        $translation = $this->translations
            ? $this->translations->firstWhere('language.code', $locale)
            : null;

        return [
            'id' => $this->id,
            'type' => $this->block_type,
            'sort_order' => $this->sort_order,
            'link_url' => $this->link_url,
            'settings' => $this->normalizeFrontendImagePaths($this->settings ?? []),
            'data' => $this->normalizeFrontendImagePaths($this->data ?? []),
            'title' => $translation?->title,
            'subtitle' => $translation?->subtitle,
            'summary' => $translation?->summary,
            'body' => $translation?->body,
            'cta_label' => $translation?->cta_label,
            'secondary_cta_label' => $translation?->secondary_cta_label,
            'media' => $this->whenLoaded('mediaAsset', fn () => $this->mediaAsset ? new MediaAssetResource($this->mediaAsset) : null),
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
