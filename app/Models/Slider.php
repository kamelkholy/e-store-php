<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Slider extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'title',
        'sortOrder',
    ];
    protected $fillable = ['title', 'sortOrder', 'image'];
}
