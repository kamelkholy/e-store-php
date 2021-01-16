<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;
use App\Models\CategoriesLinker;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = Product::sortable()->paginate(10)->withQueryString();
        return view('products.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all('name', 'id');
        $categories = Category::all('name', 'id', 'level');
        $links = new CategoriesLinker();
        $categoriesNames = [];
        $links = $links->getAll();
        foreach ($links as $key => $value) {
            if (!isset($categoriesNames[$value->id])) {
                $categoriesNames[$value->id] = $value->name;
            }
            $parentToName = $value->parent;
            for ($i = 0; $i < $value->level; $i++) {
                $index = array_search($parentToName, array_column($categories->toArray(), 'id'));
                $parent = $categories[$index];

                $parentToName = $parent->parent;
                $categoriesNames[$value->id] = $parent->name . ' > ' . $categoriesNames[$value->id];
            }
        }
        $types = Type::all('name', 'id', 'specifications');
        return view('products.create', [
            'brands' => $brands,
            'categories' => $categories,
            'categoriesNames' => $categoriesNames,
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'name_ar'  => 'required',
            'sortOrder'  => 'integer|nullable',
        ]);

        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        Product::create($form_data);
        return redirect()->back()->with('success', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return view('products.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'name_ar'  => 'required',
            'sortOrder'  => 'integer|nullable',
        ]);
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->name_ar = $request->name_ar;
        if (isset($request->sortOrder)) {
            $product->sortOrder = $request->sortOrder;
        }
        $product->save();
        return redirect('/products')->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/products')->with('success', 'Product Updated Successfully');
    }
}
