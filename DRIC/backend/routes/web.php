<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PasswordRecoveryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login.store');
    Route::get('/admin/password/recover', [PasswordRecoveryController::class, 'create'])->name('admin.password.request');
    Route::post('/admin/password/recover', [PasswordRecoveryController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.password.email');
});

Route::post('/admin/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.logout');
