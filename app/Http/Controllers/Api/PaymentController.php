<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorCardRequest;
class PaymentController extends Controller
{
    use ApiResponseTrait;



public function store(StorCardRequest $storCardRequest)
{
    $data = $storCardRequest->validated();

    // Check if the card already exists
    $card = Card::firstOrCreate(
        ['card_number' => $data['card_number']],
        [
            'holder_name' => $data['holder_name'],
            'expiry_date' => $data['expiry_date'],
            'ccv'         => $data['ccv'],
        ]
    );

    // Get user's cart and items
    $cart = Cart::where('user_id', $data['user_id'])->first();

    if (!$cart || $cart->items->isEmpty()) {
        return $this->errorResponse('Cart is empty or not found.', 404);
    }

    // Calculate total
    $total = $cart->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });

    // Create Order
    $order = Order::create([
        "user_id"          => $data['user_id'],
        'phone_number'     => $data['phone_number'],
        'status'           => 'pending',
        'total'            => $total,
        'delivery_address' => $data['delivery_address'],
    ]);

    // Create order items
    foreach ($cart->items as $item) {
        OrderItems::create([
            'order_id'   => $order->id,
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'price'      => $item->price,
        ]);
    }

    // Optional: clear the cart
    $cart->items()->delete();

    return $this->successResponse(
        [
            'order' => $order->load('items.product'),
        ],
        'Order created and payment processed.',
        200
    );
}


    
}
