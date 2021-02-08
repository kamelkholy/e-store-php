<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'city',
        'status',
        'total',
    ];
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'city',
        'products',
        'status',
        'quantity',
        'customer_message',
        'staff_notes',
        'payment_method',
        'shipping_fees',
        'sub_total',
        'total',
    ];
}
