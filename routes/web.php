<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/country', [CountryController::class, 'index']);
Route::get('/country/{country}', [CountryController::class, 'show']);

// API routes
Route::prefix('api')->middleware('auth:api')->group(function () {
    Route::apiResource('visits', VisitController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
