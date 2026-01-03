<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\OrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes (Passport)
|--------------------------------------------------------------------------
*/

// =====================
// AUTH ROUTES
// =====================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Get authenticated user
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// =====================
// ORDERS API ROUTES
// =====================
Route::middleware('auth:api')->prefix('orders')->group(function () {
    Route::post('/', [OrderApiController::class, 'store']);
    Route::get('/{order}', [OrderApiController::class, 'show']);
});

// =====================
// PACKAGES API ROUTES
// =====================
Route::middleware('auth:api')->prefix('packages')->group(function () {
    Route::get('/search', [PackageApiController::class, 'search']);
    Route::get('/product/{productId}', [PackageApiController::class, 'getByProduct']);
    Route::get('/', [PackageApiController::class, 'index']);
    Route::get('/{id}', [PackageApiController::class, 'show']);
    Route::post('/', [PackageApiController::class, 'store']);
    Route::put('/{id}', [PackageApiController::class, 'update']);
    Route::patch('/{id}', [PackageApiController::class, 'update']);
    Route::delete('/{id}', [PackageApiController::class, 'destroy']);
});
