<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'flat_shipping',
        'address',
        'phone',
        'email'
    ];
}
