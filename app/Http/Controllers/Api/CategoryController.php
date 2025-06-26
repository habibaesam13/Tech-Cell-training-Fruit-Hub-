<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\ProductResource;
class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $categories =
            Category::all();
        return $this->successResponse($categories);
    }

    public function products(Category $category)
    {
        $products = $category->products()->with('category')->paginate(5);
      
        return $this->successResponse([
            'products' =>  ProductResource::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ], 'Products retrieved successfully');
    }
}
