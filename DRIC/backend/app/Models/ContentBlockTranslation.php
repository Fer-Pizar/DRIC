<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentBlockTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contentBlock(): BelongsTo
    {
        return $this->belongsTo(ContentBlock::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}