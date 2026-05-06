<?php

use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/pages/{slug}/{locale}', [PageController::class, 'show']);
Route::get('/pages/{slug}', [PublicPageController::class, 'show']);