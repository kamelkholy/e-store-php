<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PromoCode extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'code',
        'discount',
        'discount_type',
        'applicability',
        'start_date',
        'end_date',
    ];
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'applicability',
        'start_date',
        'end_date',
        'products',
        'categories',
    ];
}
