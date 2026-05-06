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
            'settings' => $this->settings ?? [],
            'data' => $this->data ?? [],
            'title' => $translation?->title,
            'body' => $translation?->body,
            'cta_label' => $translation?->cta_label,
            'media' => $this->whenLoaded('mediaAsset', fn () => new MediaAssetResource($this->mediaAsset)),
        ];
    }
}