<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        "name",
        "price",
        "description",
        "image",
        "quantity",
    ];

    public function cartItems()
{
    return $this->hasMany(CartItems::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItems::class);
}

}
