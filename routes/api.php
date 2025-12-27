<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ====> START V1 ROUTES <====
Route::prefix('v1')->group(function () {
    //route to test if the api is working
    Route::get('ping', fn() => response()->json(['message' => 'pong (extension)']));
    // ====> START PROTECTED ROUTES <====
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
// ====> END V1 ROUTES <====
