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
}
