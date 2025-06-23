<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItems;
use App\Models\Product;

class CartController extends Controller
{
    // Add item to cart
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $product = Product::findOrFail($request->product_id);

        // Check if the item already exists in the cart
        $cartItem = CartItems::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = CartItems::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'message' => 'Item added to cart successfully',
            'item' => $cartItem->load('product'),
        ]);
    }

    // List all items in cart
    public function listItems(Request $request)
    {
        $cartItems = CartItems::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'items' => $cartItems,
        ]);
    }
}
