<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\FeaturedCategory;
use App\Models\Product;
use Image;

class FeaturedCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = FeaturedCategory::sortable()->paginate(10)->withQueryString();
        return view('featuredCategories.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all('name', 'id');
        return view('featuredCategories.create', ['categories' => $categories]);
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
            'category'  => 'required',
            'products_limit'  => 'required|integer',
            'sortOrder'  => 'integer|nullable',
            'banner' => 'required|image|max:2048',
            'featured_img' => 'required|image|max:2048'
        ]);
        $image_file = $request->banner;
        $banner = Image::make($image_file);
        Response::make($banner->encode('jpeg'));
        $image_file = $request->featured_img;
        $featured_img = Image::make($image_file);
        Response::make($featured_img->encode('jpeg'));
        $form_data = array(
            'category'  => $request->category,
            'featured_product'  => $request->featured_product,
            'products_limit'  => $request->products_limit,
            'banner' => $banner,
            'featured_img' => $featured_img,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        FeaturedCategory::create($form_data);
        return redirect()->back()->with('success', 'FeaturedCategory Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = FeaturedCategory::findOrFail($id);
        $image_file = Image::make($image->banner);
        $response = Response::make($image_file->encode('jpeg'));
        $response->header('Content-Type', 'image/jpeg');
        return $response;
    }
    public function getProducts($id)
    {
        $products = Product::where('category', $id)->select('id', 'name', 'category')->get();
        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FeaturedCategory::findOrFail($id);
        $categories = Category::all('name', 'id');
        $products = Product::where('category', $id)->select('id', 'name', 'category')->get();

        return view('featuredCategories.edit', ['data' => $data, 'categories' => $categories, 'products' => $products]);
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
            'category'  => 'required',
            'products_limit'  => 'required|integer',
            'sortOrder'  => 'integer|nullable',
            'banner' => 'image|max:2048',
            'featured_img' => 'image|max:2048'
        ]);
        $featuredCategory = FeaturedCategory::findOrFail($id);
        $featuredCategory->category = $request->category;
        $featuredCategory->products_limit = $request->products_limit;
        $featuredCategory->featured_product = $request->featured_product;
        if (isset($request->sortOrder)) {
            $featuredCategory->sortOrder = $request->sortOrder;
        }
        if (isset($request->banner)) {
            $image_file = $request->banner;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $featuredCategory->banner = $image;
        }
        if (isset($request->featured_img)) {
            $image_file = $request->featured_img;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $featuredCategory->featured_img = $image;
        }

        $featuredCategory->save();
        return redirect('/featuredCategories')->with('success', 'FeaturedCategory Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $featuredCategory = FeaturedCategory::findOrFail($id);

        $featuredCategory->delete();
        return redirect('/featuredCategories')->with('success', 'FeaturedCategory Updated Successfully');
    }
}
