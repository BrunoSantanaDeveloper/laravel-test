<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\ProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/reports', [ReportController::class, 'index']);
Route::post('/v1/reports', [ReportController::class, 'store']);
Route::get('/v1/reports/{id}', [ReportController::class, 'show']);
Route::put('/v1/reports/{id}', [ReportController::class, 'update']);
Route::delete('/v1/reports/{id}', [ReportController::class, 'destroy']);
Route::post('/v1/reports/{id}/profiles', [ReportController::class, 'createProfile']);
Route::get('/v1/profiles/{id}', [ProfileController::class, 'show']);
