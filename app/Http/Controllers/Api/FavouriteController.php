<?php


namespace App\Http\Controllers\Api;

use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class FavouriteController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $user = Auth::user();

        $favourites = $user->favourites()
            ->select('products.id', 'products.name', 'products.price', 'products.image')
            ->get();

        $favouriteProducts = $favourites->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ];
        });
        return $this->successResponse($favouriteProducts, 'success', 201);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user()->favourites()->syncWithoutDetaching($request->product_id);

        return  $this->successResponse(null, "Product added to favourites", 201);
    }

}
