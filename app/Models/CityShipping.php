<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class CityShipping extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'shipping_fees',
    ];
    protected $fillable = ['name', 'shipping_fees'];
    public function search($key)
    {
        return $this->where('name', 'LIKE', '%' . $key . '%');
    }
}
