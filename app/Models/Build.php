<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Build extends Model
{
    use HasFactory;
    use Sortable;

    public $sortable = [
        'id',
        'build_name',
        'build_access',
    ];
    protected $fillable = [
        'build_name',
        'build_access',
        'processor',
        'motherboard',
        'ram',
        'primary_storage',
        'secondary_storage',
        'gpu',
        'tower',
        'tower_cooler',
        'optical_drive',
        'cpu_cooler',
        'power_supply',
        'monitor',
        'keyboard',
        'mouse',
        'headphone',
    ];
}
