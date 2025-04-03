<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::apiResource('visit', VisitController::class);
    Route::apiResource('country', CountryController::class);
    Route::apiResource('advice', AdviceController::class);
    Route::apiResource('wishlist', WishlistController::class);
});
