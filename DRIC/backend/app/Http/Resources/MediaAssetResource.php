<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaAssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->query('locale', 'es');

        $translation = $this->translations
            ? $this->translations->firstWhere('language.code', $locale)
            : null;

        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'mime_type' => $this->mime_type,
            'file_size' => $this->file_size,
            'disk' => $this->disk,
            'url' => $this->file_path ? $request->getSchemeAndHttpHost().'/storage/'.ltrim($this->file_path, '/') : null,
            'alt_text' => $translation?->alt_text,
            'caption' => $translation?->caption,
        ];
    }
}
