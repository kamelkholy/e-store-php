<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcBuildSettings extends Model
{
    use HasFactory;
    protected $fillable = [
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
    public function findOrCreate()
    {
        $data = $this->where([])->get();
        if (count($data) == 0) {
            $form_data = array(
                'processor' => 0,
                'motherboard' => 0,
                'ram' => 0,
                'primary_storage' => 0,
                'secondary_storage' => 0,
                'gpu' => 0,
                'tower' => 0,
                'tower_cooler' => 0,
                'optical_drive' => 0,
                'cpu_cooler' => 0,
                'power_supply' => 0,
                'monitor' => 0,
                'keyboard' => 0,
                'mouse' => 0,
                'headphone' => 0,
            );
            $data = $this->create($form_data);
        } else {
            $data = $data[0];
        }
        return $data;
    }
}
