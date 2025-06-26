<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $query = $request->input('search');

        $products = Product::when($query, function ($q) use ($query) {
            return $q->where('name', 'LIKE', '%' . $query . '%');
        })->get();

        return $this->successResponse([
            'products' => ProductResource::collection($products),
        ], 'Products retrieved successfully', 200);
    }


    public function show(Product $product)
    {
        return $this->successResponse(
            [
                'product' =>  ProductResource::collection($product),
            ],
            'Product retrieved successfully',
            200
        );
    }
}
