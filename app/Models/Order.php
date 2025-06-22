<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        "user_id",
        "total",
        "phone_number",
        "status",
        "delivery_address",
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItems::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}

}
