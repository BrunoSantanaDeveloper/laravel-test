<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [ReportController::class, 'reportsWithProfiles'])->name('reports.with.profiles');

Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/{profile}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/{profile}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/{profile}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    Route::prefix('{report}/profiles')->group(function () {
        Route::get('/', [ReportController::class, 'profile'])->name('reports.profile');
        Route::post('/', [ReportController::class, 'attachProfile'])->name('reports.attachProfile');
        Route::delete('/{profile}', [ReportController::class, 'detachProfile'])->name('reports.detachProfile');
    });

    Route::get('/{report}/pdf', [ReportController::class, 'generatePdf'])->name('report.pdf');
});
