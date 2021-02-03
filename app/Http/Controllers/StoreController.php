<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoriesLinker;
use App\Models\ProductImages;
use App\Models\ProductTags;
use App\Models\CityShipping;
use App\Models\StoreSettings;

use Image;
use Illuminate\Support\Facades\DB;

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
    function cart()
    {
        $brands = Brand::all();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));

        return view('store.cart', ['brands' => $brands, 'parents' => $parentsData, 'children' => $children]);
    }
    function checkout(Request $request)
    {
        $productIds = [];
        $shippingFees = 0;
        $total = 0;
        $isCustomShipping = false;
        foreach ($request->products as $key => $value) {
            array_push($productIds, $value['id']);
        }
        $settings = StoreSettings::where([])->get();
        if (count($settings) == 0) {
            $form_data = array(
                'address'  => '',
                'email'  => '',
                'phone'  => '',
                'flat_shipping'  => 50,
            );
            $settings = StoreSettings::create($form_data);
        } else {
            $settings = $settings[0];
        }
        $products = Product::whereIn('id', $productIds)->select('id', 'name', 'price', 'quantity', 'shippingType', 'shipping_fees', 'enable_discount', 'discount')->get();
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]->bought_qty = $request->products[$products[$i]->id]['quantity'];
            if ($products[$i]->bought_qty > $products[$i]->quantity) {
                return redirect()->back()->withErrors(['message' => "Not Enough in Stock"]);
            }
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
                $total += $products[$i]->final_price * $products[$i]->bought_qty;
            } else {
                $total += $products[$i]->price * $products[$i]->bought_qty;
            }
            switch ($products[$i]->shippingType) {
                case 'calculated':
                    $shippingFees += $products[$i]->shipping_fees * $products[$i]->bought_qty;
                    $isCustomShipping = true;
                    break;
                case 'flat':
                    $shippingFees += $settings->flat_shipping;
                    break;
                case 'free':
                    break;
            }
        }
        $cityShippings = CityShipping::all();
        return view('store.checkout', [
            'products' => $products,
            'cityShippings' => $cityShippings,
            'shipping_fees' => $shippingFees,
            'total' => $total,
            'isCustomShipping' => $isCustomShipping
        ]);
    }
    function compare()
    {

        $brands = Brand::all();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));

        return view('store.compare', ['brands' => $brands, 'parents' => $parentsData, 'children' => $children]);
    }
    function compareProducts(Request $request)
    {
        $request->validate([
            'products' => 'required'
        ]);
        // return ($request->products);
        $products = Product::leftJoin('types as t', 'products.type', '=', 't.id')
            ->leftJoin('brands as b', 'products.brand', '=', 'b.id')
            ->whereIn('products.id', $request->products)
            ->select('products.*', 't.name as type_name', 't.specifications as type_specs', 'b.name as brand_name')
            ->get();
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
            }
        }
        return $products;
    }
    function refreshCart(Request $request)
    {
        $request->validate([
            'products' => 'required'
        ]);
        // return ($request->products);
        $products = Product::leftJoin('types as t', 'products.type', '=', 't.id')
            ->leftJoin('brands as b', 'products.brand', '=', 'b.id')
            ->leftJoin('product_images as pi', function ($q) {
                $q->on('pi.product', '=', 'products.id')
                    ->on(
                        'pi.id',
                        '=',
                        DB::raw('(select min(id) from product_images where product = pi.product)')
                    );
            })
            ->whereIn('products.id', $request->products)
            ->select('products.*', 't.name as type_name', 't.specifications as type_specs', 'b.name as brand_name', 'pi.id as image_id')
            ->get();
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
            }
        }

        return $products;
    }
    function products(Request $request)
    {
        $priceFrom = $request->query('from');
        $priceTo = $request->query('to');
        $brandsFilter = $request->query('brands_filter');
        $categoriesFilter = $request->query('categories_filter');
        $searchKey = $request->query('search');
        $products = new Product();
        $existingBrands = [];
        $existingCategories = [];
        if ($searchKey) {
            $products = $products->searchProducts($searchKey, $brandsFilter, $categoriesFilter, $priceFrom, $priceTo);
            $existingBrands = Product::leftJoin('brands as b', 'b.id', '=', 'brand')
                ->where('products.name', 'LIKE', '%' . $searchKey . '%')
                ->orWhere('products.name_ar', 'LIKE', '%' . $searchKey . '%')
                ->orWhere('products.description', 'LIKE', '%' . $searchKey . '%')
                ->select('brand as id', 'b.name as brand_name', DB::raw('count(*) as count'))
                ->groupBy('brand', 'brand_name')->get();
            $existingCategories = Product::leftJoin('categories as c', 'c.id', '=', 'category')
                ->where('products.name', 'LIKE', '%' . $searchKey . '%')
                ->orWhere('products.name_ar', 'LIKE', '%' . $searchKey . '%')
                ->orWhere('products.description', 'LIKE', '%' . $searchKey . '%')
                ->select('category as id', 'c.name as category_name', DB::raw('count(*) as count'))
                ->groupBy('category', 'category_name')->get();
        } else {
            $products = $products->getAllProducts($brandsFilter, $categoriesFilter, $priceFrom, $priceTo);
            $existingBrands = Product::leftJoin('brands as b', 'b.id', '=', 'brand')
                ->select('brand as id', 'b.name as brand_name', DB::raw('count(*) as count'))
                ->groupBy('brand', 'brand_name')->get();
            $existingCategories = Product::leftJoin('categories as c', 'c.id', '=', 'category')
                ->select('category as id', 'c.name as category_name', DB::raw('count(*) as count'))
                ->groupBy('category', 'category_name')->get();
        }
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
            }
        }
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));
        return view('store.products', [
            'products' => $products,
            'parents' => $parentsData,
            'children' => $children,
            'existingBrands' => $existingBrands,
            'existingCategories' => $existingCategories,
        ]);
    }
    function aproduct($id)
    {
        $product = Product::findOrFail($id);
        $product->specifications = json_decode($product->specifications, true);
        $product->final_price = $product->price - ($product->price * $product->discount) / 100;

        $typeSepcs = json_decode($product->typeObj->specifications,);
        $images = ProductImages::where('product', $id)->select('id', 'product')->get();

        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));

        return view('store.aproduct', ['product' => $product, 'images' => $images, 'typeSepcs' => $typeSepcs, 'parents' => $parentsData, 'children' => $children]);
    }
    function getCartProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->final_price = $product->price - ($product->price * $product->discount) / 100;
        $images = ProductImages::where('product', $id)->select('id', 'product')->get();
        $product->image_id = $images[0]->id;
        return $product;
    }
    function showProductImage($id)
    {
        $image = ProductImages::findOrFail($id);
        $image_file = Image::make($image->image);
        $response = Response::make($image_file->encode('jpeg'));
        $response->header('Content-Type', 'image/jpeg');
        return $response;
    }
    function productsByCategory(Request $request, $category)
    {
        $priceFrom = $request->query('from');
        $priceTo = $request->query('to');
        $brandsFilter = $request->query('brands_filter');
        $categoriesSubFilter = $request->query('categories_filter');
        $cat = Category::findOrFail($category);
        $categoriesFilter = [];
        array_push($categoriesFilter, $cat->id);
        $links = new CategoriesLinker();
        $links = $links->getAll();
        $index = array_search($category, array_column($links->toArray(), 'parent'));
        while ($index !== false) {
            $parent = $links[$index];
            array_push($categoriesFilter, $parent->categoryId);
            $index = array_search($parent->categoryId, array_column($links->toArray(), 'parent'));
        }
        $products = new Product();
        if (empty($categoriesSubFilter)) {
            $products = $products->getAllProducts($brandsFilter, $categoriesFilter, $priceFrom, $priceTo);
        } else {
            $products = $products->getAllProducts($brandsFilter, $categoriesSubFilter, $priceFrom, $priceTo);
        }
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
            }
        }
        $existingBrands = Product::leftJoin('brands as b', 'b.id', '=', 'brand')
            ->whereIn('products.category', $categoriesFilter)
            ->select('brand as id', 'b.name as brand_name', DB::raw('count(*) as count'))
            ->groupBy('brand', 'brand_name')->get();
        $existingCategories = Product::leftJoin('categories as c', 'c.id', '=', 'category')
            ->whereIn('products.category', $categoriesFilter)
            ->select('category as id', 'c.name as category_name', DB::raw('count(*) as count'))
            ->groupBy('category', 'category_name')->get();

        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();

        $children = $children->getChildren(($parents));

        return view('store.products', [
            'products' => $products,
            'parents' => $parentsData,
            'children' => $children,
            'existingBrands' => $existingBrands,
            'existingCategories' => $existingCategories,
        ]);
    }
}
