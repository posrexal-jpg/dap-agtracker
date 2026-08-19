<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\Api\MobileDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// PWA Offline Data Sync API
Route::middleware(['web', 'auth'])->post('/sync-locations', [App\Http\Controllers\UserLocationController::class, 'syncLocations'])->name('api.sync-locations');

Route::prefix('v1')->group(function () {
    Route::post('/login', [MobileAuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/google/config', [MobileAuthController::class, 'googleConfig']);
    Route::post('/google/login', [MobileAuthController::class, 'googleLogin'])->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MobileAuthController::class, 'me']);
        Route::put('/profile', [MobileAuthController::class, 'updateProfile']);
        Route::put('/password', [MobileAuthController::class, 'updatePassword']);
        Route::post('/logout', [MobileAuthController::class, 'logout']);
        Route::get('/bootstrap', [MobileDataController::class, 'bootstrap']);
        Route::get('/sightings', [MobileDataController::class, 'index']);
        Route::post('/sightings', [MobileDataController::class, 'store']);
        Route::delete('/sightings/{location}', [MobileDataController::class, 'destroy']);
    });
});
