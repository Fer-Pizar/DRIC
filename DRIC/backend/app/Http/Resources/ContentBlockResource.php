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
            'settings' => $this->settings ?? [],
            'data' => $this->data ?? [],
            'title' => $translation?->title,
            'subtitle' => $translation?->subtitle,
            'summary' => $translation?->summary,
            'body' => $translation?->body,
            'cta_label' => $translation?->cta_label,
            'secondary_cta_label' => $translation?->secondary_cta_label,
            'media' => $this->whenLoaded('mediaAsset', fn () => $this->mediaAsset ? new MediaAssetResource($this->mediaAsset) : null),
        ];
    }
}