<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $fillable=[
            "cart_id",
            "product_id",
            "price",
            "quantity",
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
public function cart()
{
    return $this->belongsTo(Cart::class);
}

}
