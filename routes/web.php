<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/{profile}', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

Route::get('/reports/{report}/profile', [ReportController::class, 'profile'])->name('reports.profile');
Route::post('/reports/{report}/profile', [ReportController::class, 'attachProfile'])->name('reports.attachProfile');
Route::delete('/reports/{report}/profile/{profile}', [ReportController::class, 'detachProfile'])->name('reports.detachProfile');
