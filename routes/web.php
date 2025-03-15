<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// API routes
Route::prefix('api')->middleware('auth:api')->group(function () {
    Route::apiResource('visit', VisitController::class);
    Route::apiResource('country', CountryController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
