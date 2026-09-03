<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AgreementContentController;
use App\Http\Controllers\Admin\AgreementListContentController;
use App\Http\Controllers\Admin\MembershipContentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PresentationContentController;
use App\Http\Controllers\Admin\ProjectContentController;
use App\Http\Controllers\Admin\ProjectFundingContentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('pages/{page}/presentation-content', [PresentationContentController::class, 'edit'])->name('pages.presentation.edit');
Route::put('pages/{page}/presentation-content', [PresentationContentController::class, 'update'])->name('pages.presentation.update');
Route::get('pages/{page}/agreement-content', [AgreementContentController::class, 'edit'])->name('pages.agreements.edit');
Route::put('pages/{page}/agreement-content', [AgreementContentController::class, 'update'])->name('pages.agreements.update');
Route::get('agreement-lists/{list}', [AgreementListContentController::class, 'edit'])->name('agreement-lists.edit');
Route::put('agreement-lists/{list}', [AgreementListContentController::class, 'update'])->name('agreement-lists.update');
Route::get('pages/{page}/project-content', [ProjectContentController::class, 'edit'])->name('pages.projects.edit');
Route::put('pages/{page}/project-content', [ProjectContentController::class, 'update'])->name('pages.projects.update');
Route::get('project-funding-content', [ProjectFundingContentController::class, 'edit'])->name('project-funding.edit');
Route::put('project-funding-content', [ProjectFundingContentController::class, 'update'])->name('project-funding.update');
Route::get('pages/{page}/membership-content', [MembershipContentController::class, 'edit'])->name('pages.memberships.edit');
Route::put('pages/{page}/membership-content', [MembershipContentController::class, 'update'])->name('pages.memberships.update');
Route::resource('pages', PageController::class)->except(['show', 'destroy']);
Route::resource('roles', RoleController::class)->except(['show']);
Route::resource('permissions', PermissionController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('users', UserController::class)->except(['show']);
