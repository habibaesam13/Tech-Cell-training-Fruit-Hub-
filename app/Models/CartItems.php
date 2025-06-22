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
}
