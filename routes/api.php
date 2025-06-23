<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductsController;

Route::apiResource('cart', CartController::class)->only(['index', 'store']);

Route::apiResource("products",ProductsController::class)->only(['index','show']);