<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Image;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductTags;
use App\Models\Tag;
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
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Product())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Product::sortable()->paginate(10)->withQueryString();
        }
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
        $tags = Tag::all('name', 'id');
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
            'tags' => $tags,
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
            'description'  => 'required',
            'sortOrder'  => 'integer|nullable',
            'type'  => 'required',
            'shippingType'  => 'required|in:calculated,free,flat',
            'specifications'  => 'required',
            'specifications.*'  => 'required',
            'img'  => 'required',
            'img.*'  => 'required|image|max:2048',
        ]);

        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
            'description'  => $request->description,
            'brand'  => $request->brand,
            'category'  => $request->category,
            'type'  => $request->type,
            'shippingType'  => $request->shippingType,
            'specifications'  => json_encode($request->specifications),
            'sku'  => $request->sku,
            'price'  => $request->price,
            'quantity'  => $request->quantity,
            'weight'  => $request->weight,
            'weight_class'  => $request->weight_class,
            'length'  => $request->length,
            'width'  => $request->width,
            'height'  => $request->height,
            'length_class'  => $request->length_class,
        );
        if ($request->shippingType == "calculated") {
            $request->validate(['shipping_fees'  => 'required',]);
            $form_data['shipping_fees']  = $request->shipping_fees;
        }
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        if (isset($request->enable_discount) && isset($request->discount)) {
            $form_data['enable_discount'] = true;
        } else {
            $form_data['enable_discount'] = false;
        }
        if (isset($request->discount)) {
            $form_data['discount'] = $request->discount;
        }
        $product = Product::create($form_data);
        $dataImages = [];
        foreach ($request->img as $key => $value) {
            $image_file = $value;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            array_push($dataImages, array('product' => $product->id, 'image' => $image));
        }
        if (isset($request->tags)) {
            $productTags = [];
            foreach ($request->tags as $key => $value) {
                array_push($productTags, array('product' => $product->id, 'tag' => $value));
            }
            ProductTags::insert($productTags);
        }
        ProductImages::insert($dataImages);
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
        $brands = Brand::all('name', 'id');
        $tags = Tag::all('name', 'id');
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
        $data = Product::findOrFail($id);
        $data->specifications = json_decode($data->specifications);
        $productImages = ProductImages::where('product', $id)->get();
        $productTags = ProductTags::where('product', $id)->get();
        return view('products.edit', [
            'data' => $data,
            'brands' => $brands,
            'tags' => $tags,
            'categories' => $categories,
            'categoriesNames' => $categoriesNames,
            'types' => $types,
            'productImages' => $productImages,
            'productTags' => $productTags
        ]);
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
            'description'  => 'required',
            'sortOrder'  => 'integer|nullable',
            'type'  => 'required',
            'shippingType'  => 'required|in:calculated,free,flat',
            'specifications'  => 'required',
            'specifications.*'  => 'required',
        ]);

        $product = Product::findOrFail($id);
        if ($request->shippingType == "calculated") {
            $request->validate(['shipping_fees'  => 'required',]);
            $product->shipping_fees  = $request->shipping_fees;
        }
        $product->name = $request->name;
        $product->name_ar = $request->name_ar;
        $product->description  = $request->description;
        $product->brand  = $request->brand;
        $product->category  = $request->category;
        $product->type  = $request->type;
        $product->shippingType  = $request->shippingType;
        $product->specifications  = json_encode($request->specifications);
        $product->sku  = $request->sku;
        $product->price  = $request->price;
        $product->quantity  = $request->quantity;
        $product->weight  = $request->weight;
        $product->weight_class  = $request->weight_class;
        $product->length  = $request->length;
        $product->width  = $request->width;
        $product->height  = $request->height;
        $product->length_class  = $request->length_class;
        if (isset($request->sortOrder)) {
            $product->sortOrder = $request->sortOrder;
        }
        if (isset($request->enable_discount) && isset($request->discount)) {
            $product->enable_discount = true;
        } else {
            $product->enable_discount = false;
        }
        if (isset($request->discount)) {
            $product->discount = $request->discount;
        }
        if (isset($request->tags)) {
            $productTags = [];
            foreach ($request->tags as $key => $value) {
                array_push($productTags, array('product' => $product->id, 'tag' => $value));
            }
            ProductTags::where('product', $product->id)->delete();
            ProductTags::insert($productTags);
        }
        if (isset($request->deleted_images)) {
            $deleteImages = [];
            foreach ($request->deleted_images as $key => $value) {
                array_push($deleteImages, $value);
            }
            ProductImages::whereIn('id', $deleteImages)->delete();
        }
        if (isset($request->img)) {
            $dataImages = [];
            foreach ($request->img as $key => $value) {
                $image_file = $value;
                $image = Image::make($image_file);
                Response::make($image->encode('jpeg'));
                array_push($dataImages, array('product' => $product->id, 'image' => $image));
            }
            ProductImages::insert($dataImages);
        }
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
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
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }
}
