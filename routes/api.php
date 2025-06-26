<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CartController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\CategoryController;


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('cart', CartController::class)->only(['index', 'store']);
    Route::apiResource("products", ProductsController::class)->only(['index', 'show']);
    Route::apiResource("payment", PaymentController::class)->only(['store']);
    Route::apiResource("favourites", FavouriteController::class)->only(['index', 'store']);
    Route::post('/logout', [AuthController::class, 'Logout']);
});
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}/products', [CategoryController::class, 'products']);
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);
