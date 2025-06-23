<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\StoreCartItemRequest;

class CartController extends Controller
{
    use ApiResponseTrait;
    
    public function store(StoreCartItemRequest $request)
    {
        // $user = $request->user();
        $user = User::find(1);
        $product = Product::findOrFail($request->product_id);

            // Check stock availability
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse("Only {$product->stock} items left in stock.", 422);
        }
        // Get or create cart
        $cart = $user->cart;
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        }

        $cartId = $cart->id; 
        $cartItem = CartItems::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        

        if ($cartItem) {
            // Check again for total quantity if increasing
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->quantity < $newQuantity) {
                return $this->errorResponse("Cannot add. Total exceeds stock ({$product->stock}).", 422);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = CartItems::create([
                'cart_id' =>$cartId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        // Deduct stock from product
        $product->quantity -= $request->quantity;
        $product->save();

        return $this->successResponse(
            ['item' => $cartItem->load('product')],
            'Item added to cart and product stock updated.',
            200
        );
    }


    public function index(Request $request)
{
    $user = User::find(1);
    $cart = $user->cart;

    if (!$cart) {
        return response()->json([
            'message' => 'Cart is empty or not created yet.',
            'items' => [],
        ]);
    }

    $cartItems = CartItems::with('product')
        ->where('cart_id', $cart->id)
        ->get();

    return response()->json([
        'items' => $cartItems,
    ]);
}

}
