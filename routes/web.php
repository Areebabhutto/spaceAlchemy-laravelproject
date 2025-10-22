<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\indexController;
use App\Http\Controllers\frontend\cartController;
use App\Http\Controllers\frontend\checkoutController;
use App\Http\Controllers\frontend\loginController;
use App\Http\Controllers\frontend\productdetailController;
use App\Http\Controllers\frontend\productsController;
use App\Http\Controllers\frontend\signupController;


Route::get('/',[indexController::class,'index']);
Route::get('/cart',[cartController::class,'index']);
Route::get('/checkout',[checkoutController::class,'index']);
Route::get('/login',[loginController::class,'index']);
Route::get('/product-detail',[productdetailController::class,'index']);
Route::get('/products',[productsController::class,'index']);
Route::get('/signup',[signupController::class,'index']);