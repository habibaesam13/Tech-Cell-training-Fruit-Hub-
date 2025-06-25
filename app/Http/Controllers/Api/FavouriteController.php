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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user()->favourites()->syncWithoutDetaching($request->product_id);

        return  $this->successResponse(null, "Product added to favourites", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite) {}
}
