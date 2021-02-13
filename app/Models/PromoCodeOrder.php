<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order',
        'promo_code'
    ];
}
