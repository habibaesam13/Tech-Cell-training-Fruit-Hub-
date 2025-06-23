<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CartController;

Route::apiResource('cart', CartController::class)->only(['index', 'store']);


