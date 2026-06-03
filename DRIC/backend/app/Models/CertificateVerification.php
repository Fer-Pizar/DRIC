<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateVerification extends Model
{
    protected $fillable = [
        'code',
        'full_name',
        'certificate_type',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}