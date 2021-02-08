<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class FeaturedCategory extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'sortOrder',
    ];
    protected $fillable = [
        'category',
        'featured_product',
        'products_limit',
        'banner',
        'featured_img',
        'sortOrder',
    ];
}
