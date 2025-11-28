<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendProductController;
use App\Http\Controllers\Frontend\IndexController; 
use App\Http\Controllers\Frontend\CartController; 
use App\Http\Controllers\Frontend\CheckoutController; 
use App\Http\Controllers\Frontend\LoginController; 
use App\Http\Controllers\Frontend\ProductDetailController; 
use App\Http\Controllers\Frontend\ProductsController; 
use App\Http\Controllers\Frontend\SignupController;

// Frontend routes
Route::get('/', [IndexController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::get('/checkout', [CheckoutController::class, 'index']);
//Route::get('/login', [LoginController::class, 'index']);
Route::get('/product-detail', [ProductDetailController::class, 'index']);
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/signup', [SignupController::class, 'index']);

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('products', BackendProductController::class);
    Route::resource('services', \App\Http\Controllers\BackendServiceController::class);
});

require __DIR__.'/auth.php';
