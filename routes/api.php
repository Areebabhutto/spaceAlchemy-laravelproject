<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageApiController;

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

// Package API Routes
Route::prefix('packages')->group(function () {
    // Search packages by name or description
    Route::get('search', [PackageApiController::class, 'search']);
    
    // Get packages by product ID
    Route::get('product/{productId}', [PackageApiController::class, 'getByProduct']);
    
    // Standard REST endpoints
    Route::get('/', [PackageApiController::class, 'index']);
    Route::get('/{id}', [PackageApiController::class, 'show']);
    Route::post('/', [PackageApiController::class, 'store']);
    Route::put('/{id}', [PackageApiController::class, 'update']);
    Route::patch('/{id}', [PackageApiController::class, 'update']);
    Route::delete('/{id}', [PackageApiController::class, 'destroy']);
});
