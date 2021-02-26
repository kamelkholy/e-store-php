<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DailyOffer extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'start_date',
        'end_date',
    ];
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'products',
    ];
    public function search($key)
    {
        return $this->where('name', 'LIKE', '%' . $key . '%');
    }
}
