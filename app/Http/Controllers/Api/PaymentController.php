<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\Card;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorCardRequest;

class PaymentController extends Controller
{
    use ApiResponseTrait;
public function store(StorCardRequest $storCardRequest)
{
    $data = $storCardRequest->validated();
    $userId = Auth::user()->id;
    // Get user's cart and items
    $cart = Cart::where('user_id', $userId)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return $this->errorResponse('Cart is empty or not found.', 404);
    }

    // Calculate total
    $total = $cart->items->sum(fn($item) => $item->price * $item->quantity);

    // Create Order
    $order = Order::create([
        'user_id'          => $userId,
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

    // Handle payment
    $paymentMethod = $data['payment_method'];
    $cardId = null;

    if ($paymentMethod === 'visa') {
        $card = Card::firstOrCreate(
            ['card_number' => $data['card_number']],
            [
                'holder_name' => $data['holder_name'],
                'expiry_date' => $data['expiry_date'],
                'ccv'         => $data['ccv'],
                'user_id'     => $userId, // optional: associate card with user
            ]
        );
        $cardId = $card->id;
    }

    // Create payment record
    $payment = Payment::create([
        'order_id'        => $order->id,
        'card_id'         => $cardId,
        'payment_method'  => $paymentMethod,
        'status'          => $paymentMethod === 'visa' ? 'paid' : 'pending',
        'paid_at'         => $paymentMethod === 'visa' ? Carbon::now() : null,
        'transaction_id'  => $paymentMethod === 'visa' ? uniqid('TXN') : null,
    ]);

    // Update order status if paid
    if ($paymentMethod === 'visa') {
        $order->update(['status' => 'paid']);
    }

    // Clear cart items
    $cart->items()->delete();

    return $this->successResponse(
        [
            'order'   => $order->load('items.product'),
            'payment' => $payment,
        ],
        'Order created and payment processed.',
        200
    );
}

}
