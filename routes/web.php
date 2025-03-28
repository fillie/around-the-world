<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

// API routes
Route::prefix('api')->middleware('auth:api')->group(function () {
    Route::apiResource('visit', VisitController::class);
    Route::apiResource('country', CountryController::class);
    Route::post('/advice', [AdviceController::class, 'generate']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
