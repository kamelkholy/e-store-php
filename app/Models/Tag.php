<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tag extends Model
{
    use Sortable;

    public $sortable = [
        'id',
        'name',
        'name_ar',
        'sortOrder',
    ];
    protected $fillable = ['name', 'name_ar', 'sortOrder'];
    public function search($key)
    {
        return $this->where('name', 'LIKE', '%' . $key . '%')->orWhere('name_ar', 'LIKE', '%' . $key . '%');
    }
}
