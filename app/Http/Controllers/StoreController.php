<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoriesLinker;
use Image;

class StoreController extends Controller
{
    function index()
    {
        $brands = Brand::all();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();

        $children = $children->getChildren(($parents));

        return view('store', ['brands' => $brands, 'parents' => $parentsData, 'children' => $children]);
    }
}
