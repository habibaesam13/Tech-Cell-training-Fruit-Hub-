<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $products = Product::all();

    return $this->successResponse([
        'products' => $products
    ],'Products retrived successfully',200);
    }

public function show(Product $product)
{
    return $this->successResponse([
        'product' => $product
    ], 'Product retrieved successfully',
200);
}
}
