<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoriesLinker;
use App\Models\ProductImages;
use App\Models\ProductTags;
use App\Models\CityShipping;
use App\Models\DailyOffer;
use App\Models\FeaturedCategory;
use App\Models\FeaturedImage;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PcBuildSettings;
use App\Models\PromoCode;
use App\Models\PromoCodeOrder;
use App\Models\Slider;
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
        $sliders = Slider::all()->sortBy('sortOrder');
        $featuredImages = FeaturedImage::all()->sortBy('sortOrder');

        $now = Carbon::now();
        $dailyOffers = DailyOffer::whereDate('start_date', '<=', $now)->whereDate('end_date', '>=', $now)->get();
        $dailyOffer = count($dailyOffers) > 0 ? $dailyOffers[0] : NULL;
        if ($dailyOffer) {
            $dailyIds = json_decode($dailyOffer->products);
            $dailyProducts = Product::leftJoin('product_images as pi', function ($q) {
                $q->on('pi.product', '=', 'products.id')
                    ->on(
                        'pi.id',
                        '=',
                        DB::raw('(select min(id) from product_images where product = pi.product)')
                    );
            })
                ->whereIn('products.id', $dailyIds)
                ->limit(2)
                ->select('products.*', 'pi.image', 'pi.id as image_id')
                ->get();
            for ($i = 0; $i < count($dailyProducts); $i++) {
                if ($dailyProducts[$i]->enable_discount) {
                    $dailyProducts[$i]->final_price = $dailyProducts[$i]->price - ($dailyProducts[$i]->price * $dailyProducts[$i]->discount) / 100;
                }
            }
            $dailyOffer->products = $dailyProducts;
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $dailyOffer->end_date);;
            $dailyOffer->remaining = $endDate->diff($now);
        }


        $featuredCategories = FeaturedCategory::leftJoin('categories as c', 'category', '=', 'c.id')
            ->leftJoin('products as p', 'featured_product', '=', 'p.id')
            ->leftJoin('product_images as pi', function ($q) {
                $q->on('pi.product', '=', 'featured_categories.featured_product')
                    ->on(
                        'pi.id',
                        '=',
                        DB::raw('(select min(id) from product_images where product = pi.product)')
                    );
            })->select('p.id as featured_product_id', 'p.name as featured_product_name', 'p.price as featured_product_price', 'p.enable_discount as featured_product_enable_discount', 'p.discount as featured_product_discount', 'pi.image as featured_product_image', 'featured_categories.*', 'c.name as category_name')->get()->sortBy('sortOrder');
        foreach ($featuredCategories as $key => $value) {
            $value->final_price = $value->featured_product_price - ($value->featured_product_price * $value->featured_product_discount) / 100;
            $products = Product::leftJoin('product_images as pi', function ($q) {
                $q->on('pi.product', '=', 'products.id')
                    ->on(
                        'pi.id',
                        '=',
                        DB::raw('(select min(id) from product_images where product = pi.product)')
                    );
            })
                ->select('products.*', 'pi.image as image')
                ->where('category', $value->category)->limit($value->products_limit)->get()->sortBy('sortOrder');
            for ($i = 0; $i < count($products); $i++) {
                if ($products[$i]->enable_discount) {
                    $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
                }
            }
            $value->products = $products;
        }

        return view('store', ['featuredCategories' => $featuredCategories, 'dailyOffer' => $dailyOffer, 'sliders' => $sliders, 'featuredImages' => $featuredImages, 'brands' => $brands, 'parents' => $parentsData, 'children' => $children]);
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
        $request->validate(['products' => 'required']);
        $productIds = [];
        $shippingFees = 0;
        $total = 0;
        $isCustomShipping = false;
        foreach ($request->products as $key => $value) {
            array_push($productIds, $value['id']);
        }
        $settings = new StoreSettings();
        $settings = $settings->findOrCreate();
        $promo = NULL;
        $promoApplied = false;
        $totalPromoDiscount = 0;
        if (isset($request->promo_code)) {
            $promo = PromoCode::where('code', $request->promo_code)->get();
            if (count($promo) == 0) {
                return redirect()->back()->withErrors(['message' => "Invalid Promo Code"]);
            }
            $promo = $promo[0];
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s',  $promo->start_date);;
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $promo->end_date);
            $now = Carbon::now();
            if ($now->gt($endDate) || $now->lt($startDate)) {
                return redirect()->back()->withErrors(['message' => "Promo Code is Inactive or Expired"]);
            }
            $promo->products = ($promo->products) ? json_decode($promo->products) : [];
            $promo->categories = ($promo->categories) ? json_decode($promo->categories) : [];
            $promoApplied = true;
        }
        $products = Product::whereIn('id', $productIds)->select('id', 'name', 'price', 'quantity', 'shippingType', 'shipping_fees', 'enable_discount', 'discount')->get();
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]->bought_qty = $request->products[$products[$i]->id]['quantity'];
            if ($products[$i]->bought_qty > $products[$i]->quantity) {
                return redirect()->back()->withErrors(['message' => "Not Enough in Stock"]);
            }
            if (!$products[$i]->price) {
                return redirect()->back()->withErrors(['message' => "Please Contact The Store Owner About Ordering The Item: " . $products[$i]->name]);
            }

            $productApplicable = false;
            $promoDiscount = 0;
            if ($promo) {
                switch ($promo->applicability) {
                    case 'all':
                        $productApplicable = true;
                        break;
                    case 'some':
                        if (array_search($products[$i]->id, $promo->products) !== false) {
                            $productApplicable = true;
                        }
                        break;
                    case 'categories':
                        if (array_search($products[$i]->category, $promo->categories) !== false) {
                            $productApplicable = true;
                        }
                        break;
                }
                $products[$i]->promo_applicable = $productApplicable;
                if ($productApplicable) {
                    if ($promo->discount_type == "percentage") {
                        $promoDiscount = ($products[$i]->price * $promo->discount) / 100;
                    } elseif ($promo->discount_type == "ammount") {
                        $promoDiscount = $promo->discount;
                    }
                }
                $totalPromoDiscount += $promoDiscount * $products[$i]->bought_qty;
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
            'isCustomShipping' => $isCustomShipping,
            'promoDiscount' => $totalPromoDiscount,
            'promoApplied' => $promoApplied,
            'promoCode' => ($promoApplied) ? $promo->code : '',
        ]);
    }
    function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'payment' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('store.cart')
                ->withErrors($validator)
                ->withInput();
        }

        $productIds = [];
        $orderProducts = [];
        $shippingFees = 0;
        $total = 0;
        $total_qty = 0;
        $isCustomShipping = false;
        foreach ($request->products as $key => $value) {
            array_push($productIds, $value['id']);
        }
        $settings = new StoreSettings();
        $settings = $settings->findOrCreate();

        $promo = NULL;
        $promoApplied = false;
        $totalPromoDiscount = 0;
        if (isset($request->promo_code)) {
            $promo = PromoCode::where('code', $request->promo_code)->get();
            if (count($promo) == 0) {
                return redirect()->back()->withErrors(['message' => "Invalid Promo Code"]);
            }
            $promo = $promo[0];
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s',  $promo->start_date);;
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $promo->end_date);
            $now = Carbon::now();
            if ($now->gt($endDate) || $now->lt($startDate)) {
                return redirect()->back()->withErrors(['message' => "Promo Code is Inactive or Expired"]);
            }
            $promo->products = ($promo->products) ? json_decode($promo->products) : [];
            $promo->categories = ($promo->categories) ? json_decode($promo->categories) : [];
            $promoApplied = true;
        }
        $products = Product::whereIn('id', $productIds)->select('id', 'name', 'price', 'quantity', 'shippingType', 'shipping_fees', 'enable_discount', 'discount')->get();
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]->bought_qty = $request->products[$products[$i]->id]['quantity'];
            if ($products[$i]->bought_qty > $products[$i]->quantity) {
                return redirect()->route('store.cart')->withErrors(['message' => "Not Enough in Stock"]);
            }
            $productApplicable = false;
            $promoDiscount = 0;
            if ($promo) {
                switch ($promo->applicability) {
                    case 'all':
                        $productApplicable = true;
                        break;
                    case 'some':
                        if (array_search($products[$i]->id, $promo->products) !== false) {
                            $productApplicable = true;
                        }
                        break;
                    case 'categories':
                        if (array_search($products[$i]->category, $promo->categories) !== false) {
                            $productApplicable = true;
                        }
                        break;
                }
                $products[$i]->promo_applicable = $productApplicable;
                if ($productApplicable) {
                    if ($promo->discount_type == "percentage") {
                        $promoDiscount = ($products[$i]->price * $promo->discount) / 100;
                    } elseif ($promo->discount_type == "ammount") {
                        $promoDiscount = $promo->discount;
                    }
                }
                $totalPromoDiscount += $promoDiscount * $products[$i]->bought_qty;
            }
            if ($products[$i]->enable_discount) {
                $products[$i]->final_price = $products[$i]->price - ($products[$i]->price * $products[$i]->discount) / 100;
                $total += $products[$i]->final_price * $products[$i]->bought_qty;
            } else {
                $total += $products[$i]->price * $products[$i]->bought_qty;
            }
            $productShipping = 0;
            switch ($products[$i]->shippingType) {
                case 'calculated':
                    $productShipping = $products[$i]->shipping_fees * $products[$i]->bought_qty;
                    $isCustomShipping = true;
                    break;
                case 'flat':
                    $productShipping = $settings->flat_shipping;
                    break;
                case 'free':
                    break;
            }
            $total_qty += $products[$i]->bought_qty;
            $shippingFees += $productShipping;
            $orderProducts[$products[$i]->id] = [
                'id' => $products[$i]->id,
                'name' => $products[$i]->name,
                'price' => $products[$i]->price,
                'final_price' => isset($products[$i]->final_price) ? $products[$i]->final_price : $products[$i]->price,
                'quantity' => $products[$i]->bought_qty,
                'shipping_fees' => $productShipping,
                'promoApplied' => ($promoApplied) ? $products[$i]->promo_applicable : false,
            ];
        }
        $cityShippings = CityShipping::all();
        $key = array_search($request->city, array_column($cityShippings->toArray(), 'id'));
        $totalShipping = ($isCustomShipping) ? $shippingFees + $cityShippings[$key]->shipping_fees : $shippingFees;
        $orderData = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'products' => json_encode($orderProducts),
            'status' => 'placed',
            'quantity' => $total_qty,
            'customer_message' => $request->message,
            'payment_method' => $request->payment,
            'shipping_fees' => $totalShipping,
            'promo_applied' => $promoApplied,
            'promo_discount' => $totalPromoDiscount,
            'promo_code' => ($promoApplied) ? $promo->code : '',
            'sub_total' => $total,
            'total' => $total + $totalShipping - $totalPromoDiscount,
        );

        $order = Order::create($orderData);
        if ($promoApplied) {
            PromoCodeOrder::create(array('order' => $order->id, 'promo_code' => $promo->id));
        }
        $productsToUpdate = new Product;
        $productsToUpdate->decreaseQuantity($products);
        // Change Product Quantities
        $orderStatusData = array(
            'status' => 'placed',
            'success' => true,
            'ordering' => 0,
            'order' => $order->id,
            'message' => 'Order Placed Successfully',
        );
        OrderStatus::create($orderStatusData);
        return redirect()->route('store');
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
    function pcBuild()
    {

        $brands = Brand::all();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));

        $pcBuildSettings = new PcBuildSettings();
        $pcBuildSettings = $pcBuildSettings->findOrCreate();
        $categories = [];
        $components = array();
        foreach ($pcBuildSettings->toArray() as $key => $value) {
            if (!in_array($key, array("id", "created_at", "updated_at"))) {
                array_push($categories, $value);
                $components[$value] = [];
            }
        }
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
            ->whereIn('category', $categories)->select('products.id', 'products.name', 'products.description', 'products.price', 'products.category', 'b.name as brand_name', 'pi.id as image_id')->get();
        foreach ($products as $key => $value) {
            $index = array_search($value->category, array_column($components, 'category'));
            array_push($components[$value->category], $value);
        }
        return view('store.pcBuild', [
            'components' => $components,
            'pcBuildSettings' => $pcBuildSettings,
            'brands' => $brands,
            'parents' => $parentsData,
            'children' => $children
        ]);
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
        $tags = ProductTags::where('product', $product->id)->select('tag')->get();
        $productsByTags = ProductTags::whereIn('tag', $tags)->select('product')->distinct()->get();
        $relatedProducts = new Product;
        $relatedProducts = $relatedProducts->getRelatedProducts($product->category, $productsByTags);
        for ($i = 0; $i < count($relatedProducts); $i++) {
            if ($relatedProducts[$i]->enable_discount) {
                $relatedProducts[$i]->final_price = $relatedProducts[$i]->price - ($relatedProducts[$i]->price * $relatedProducts[$i]->discount) / 100;
            }
        }

        $now = Carbon::now();
        $dailyOffers = DailyOffer::whereDate('start_date', '<=', $now)->whereDate('end_date', '>=', $now)->get();
        $dailyOffer = count($dailyOffers) > 0 ? $dailyOffers[0] : NULL;
        if ($dailyOffer) {

            $dailyIds = json_decode($dailyOffer->products);
            $dailyProducts = Product::leftJoin('product_images as pi', function ($q) {
                $q->on('pi.product', '=', 'products.id')
                    ->on(
                        'pi.id',
                        '=',
                        DB::raw('(select min(id) from product_images where product = pi.product)')
                    );
            })
                ->whereIn('products.id', $dailyIds)
                ->select('products.*', 'pi.image', 'pi.id as image_id')
                ->get();
            for ($i = 0; $i < count($dailyProducts); $i++) {
                if ($dailyProducts[$i]->enable_discount) {
                    $dailyProducts[$i]->final_price = $dailyProducts[$i]->price - ($dailyProducts[$i]->price * $dailyProducts[$i]->discount) / 100;
                }
            }
            $dailyOffer->products = $dailyProducts;
        }
        return view('store.aproduct', [
            'product' => $product,
            'dailyOffer' => $dailyOffer,
            'relatedProducts' => $relatedProducts,
            'images' => $images,
            'typeSepcs' => $typeSepcs,
            'parents' => $parentsData,
            'children' => $children
        ]);
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
