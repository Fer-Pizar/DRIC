<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('pages', PageController::class)->except(['show', 'destroy']);
Route::resource('roles', RoleController::class)->except(['show']);
Route::resource('permissions', PermissionController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('users', UserController::class)->except(['show']);
