<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable=[
        "order_id",
        "card_id",
        "payment_method",
        "status",
        "paid_at",
        "transaction_id",
    ];
    public function order()
{
    return $this->belongsTo(Order::class);
}

}
