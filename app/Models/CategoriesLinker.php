<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriesLinker extends Model
{
    protected $fillable = ['parent', 'categoryId', 'level', 'show_image'];
    public function getChildren($ids)
    {
        $children = DB::table('categories_linkers as c1')
            ->join('categories as c2', 'c1.categoryId', '=', 'c2.id')
            ->orderBy('c2.sortOrder')
            ->select('c1.*', 'c2.id as id', 'c2.name as name')
            ->get();
        //do whatever you want to do
        return $children;
    }
    use HasFactory;
}
