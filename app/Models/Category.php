<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $fillable = ['name', 'sortOrder', 'image', 'show_image', 'level', 'parent'];
    use HasFactory;
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
}
