<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "price",
        "description",
        "image",
        "quantity",
        "category_id",
        "ingredients"
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItems::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
    public function favouritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourites');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
   
}
