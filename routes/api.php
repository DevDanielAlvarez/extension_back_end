<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ====> START V1 ROUTES <====
Route::prefix('v1')->group(function () {
    //route to test if the api is working
    Route::get('ping', fn() => response()->json(['message' => 'pong (extension)']));
    // ====> START AUTH ROUTES <====
    // route to register user
    Route::post('register', [AuthController::class, 'register'])->name('v1.register');
    //route to login user
    Route::post('login', [AuthController::class, 'login'])->name('v1.login');
    // ====> END AUTH ROUTES <====
    // ====> START PROTECTED ROUTES <====
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('v1.user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('v1.logout');
    });
});
// ====> END V1 ROUTES <====
