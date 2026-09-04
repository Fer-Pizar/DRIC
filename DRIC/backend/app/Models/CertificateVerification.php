<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateVerification extends Model
{
    protected $fillable = [
        'code',
        'full_name',
        'certificate_type',
        'certificate_type_en',
        'description',
        'description_en',
        'issue_date',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'is_active' => 'boolean',
    ];
}
