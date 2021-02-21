<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory, Sortable;
    public $sortable = [
        'id',
        'name',
        'name_ar',
        'sortOrder',
    ];
    protected $fillable = ['name', 'name_ar', 'sortOrder', 'image', 'show_image', 'level', 'parent'];
    public function getCategoryWithParent($id)
    {
        $category = DB::table('categories as c1')
            ->leftJoin('categories as c2', 'c1.parent', '=', 'c2.id')
            ->where('c1.id', $id)
            ->select('c1.*', 'c2.id as parentId', 'c2.name as parentName')
            ->get();
        //do whatever you want to do
        return $category;
    }
    public function search($key)
    {
        return $this->where('name', 'LIKE', '%' . $key . '%')->orWhere('name_ar', 'LIKE', '%' . $key . '%');
    }
}
