<?php

use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PublicPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificateVerificationController;


Route::get('/pages/{slug}', [PublicPageController::class, 'show']);
Route::post('/certificates/verify', [CertificateVerificationController::class, 'verify']);