<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'flat_shipping',
        'address',
        'phone',
        'email'
    ];
    public function findOrCreate()
    {
        $data = $this->where([])->get();
        if (count($data) == 0) {
            $form_data = array(
                'address'  => '',
                'email'  => '',
                'phone'  => '',
                'flat_shipping'  => 50,
            );
            $data = $this->create($form_data);
        } else {
            $data = $data[0];
        }
        return $data;
    }
}
