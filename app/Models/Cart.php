<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=[
        "user_id",
    ];
    // Cart.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function cartItems()
{
    return $this->hasMany(CartItems::class);
}

}
