<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pageTranslations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function sectionTranslations(): HasMany
    {
        return $this->hasMany(SectionTranslation::class);
    }

    public function contentBlockTranslations(): HasMany
    {
        return $this->hasMany(ContentBlockTranslation::class);
    }

    public function mediaTranslations(): HasMany
    {
        return $this->hasMany(MediaTranslation::class);
    }
}