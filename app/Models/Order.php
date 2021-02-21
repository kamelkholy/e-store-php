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
        'promo_code',
        'promo_applied',
        'promo_discount',
        'quantity',
        'customer_message',
        'staff_notes',
        'payment_method',
        'shipping_fees',
        'sub_total',
        'total',
    ];
    public function search($key)
    {
        return $this->where('first_name', 'LIKE', '%' . $key . '%')->orWhere('last_name', 'LIKE', '%' . $key . '%')->orWhere('email', 'LIKE', '%' . $key . '%')->orWhere('id', $key);
    }
}
