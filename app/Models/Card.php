<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable=[
        "date",
        "card_number",
        "ccv",
        "expiry_date",
        "holder_name",
    ];
}
