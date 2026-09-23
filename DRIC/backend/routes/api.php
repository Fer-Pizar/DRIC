<?php

use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PublicPageController;
use App\Http\Controllers\Api\SiteSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificateVerificationController;
use App\Http\Controllers\Api\AppointmentRequestController;


Route::get('/site-settings', [SiteSettingController::class, 'show']);
Route::get('/pages/{slug}', [PublicPageController::class, 'show']);
Route::post('/certificates/verify', [CertificateVerificationController::class, 'verify']);
Route::post('/appointments', [AppointmentRequestController::class, 'store']);
