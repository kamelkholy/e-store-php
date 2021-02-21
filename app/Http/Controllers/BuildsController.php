<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Build;
use App\Models\Category;
use App\Models\CategoriesLinker;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BuildsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = Build::sortable()->paginate(10)->withQueryString();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));

        return view('builds.list', ['data' => $data, 'parents' => $parentsData, 'children' => $children]);
    }

    public function compare(Request $request)
    {
        $request->validate([
            'build'  => 'required',
            'build.1'  => 'required',
            'build.2'  => 'required',
        ]);
        $builds = Build::whereIn('id', $request->build)->get();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));
        $productsIds = [];

        foreach ($builds as $build) {
            foreach ($build->toArray() as $key => $value) {
                if (!in_array($key, array("id", "customer", "build_name", "build_access", "created_at", "updated_at"))) {

                    if ($value != Null && !in_array($value, $productsIds)) {
                        array_push($productsIds, $value);
                    }
                }
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
            ->whereIn('products.id', $productsIds)
            ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.category', 'b.name as brand_name', 'pi.id as image_id')->get();
        $toCompare = [];
        $cost = [];
        foreach ($builds as $buildKey => $build) {
            $toCompare[$buildKey] = [];
            $cost[$buildKey] = 0;

            foreach ($build->toArray() as $key => $value) {
                $toCompare[$buildKey][$key] = $value;

                if (!in_array($key, array("id", "customer", "build_name", "build_access", "created_at", "updated_at"))) {
                    if ($value != Null) {
                        $product = array_search($value, array_column($products->toArray(), 'id'));
                        $toCompare[$buildKey][$key] = $products[$product];
                        $cost[$buildKey] += ($products[$product]->price) ? $products[$product]->price : 0;
                    }
                }
            }
        }

        return view('store.buildCompare', [
            'builds' => $toCompare,
            'cost' => $cost,
            'parents' => $parentsData,
            'children' => $children
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('builds.create');
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
            'components'  => 'required',
            'build_name'  => 'required',
            'build_access'  => 'required|in:private,public',
        ]);

        $form_data = array(
            'build_name' => $request->build_name,
            'build_access' => $request->build_access,
            'processor' => isset($request->components['processor']) ? $request->components['processor'] : NULL,
            'motherboard' => isset($request->components['motherboard']) ? $request->components['motherboard'] : NULL,
            'ram' => isset($request->components['ram']) ? $request->components['ram'] : NULL,
            'primary_storage' => isset($request->components['primary_storage']) ? $request->components['primary_storage'] : NULL,
            'secondary_storage' => isset($request->components['secondary_storage']) ? $request->components['secondary_storage'] : NULL,
            'gpu' => isset($request->components['gpu']) ? $request->components['gpu'] : NULL,
            'tower' => isset($request->components['tower']) ? $request->components['tower'] : NULL,
            'tower_cooler' => isset($request->components['tower_cooler']) ? $request->components['tower_cooler'] : NULL,
            'optical_drive' => isset($request->components['optical_drive']) ? $request->components['optical_drive'] : NULL,
            'cpu_cooler' => isset($request->components['cpu_cooler']) ? $request->components['cpu_cooler'] : NULL,
            'power_supply' => isset($request->components['power_supply']) ? $request->components['power_supply'] : NULL,
            'monitor' => isset($request->components['monitor']) ? $request->components['monitor'] : NULL,
            'keyboard' => isset($request->components['keyboard']) ? $request->components['keyboard'] : NULL,
            'mouse' => isset($request->components['mouse']) ? $request->components['mouse'] : NULL,
            'headphone' => isset($request->components['headphone']) ? $request->components['headphone'] : NULL,
        );
        Build::create($form_data);
        return redirect()->back()->with('success', 'Build Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $builds = Build::whereIn('id', [$id])->get();
        $parentsData = Category::where('level', 0)->orderBy('sortOrder')->get();
        $parents = array();
        foreach ($parentsData as $key => $value) {
            array_push($parents, $value->id);
        }
        $children = new CategoriesLinker();
        $children = $children->getChildren(($parents));
        $productsIds = [];

        foreach ($builds as $build) {
            foreach ($build->toArray() as $key => $value) {
                if (!in_array($key, array("id", "customer", "build_name", "build_access", "created_at", "updated_at"))) {

                    if ($value != Null && !in_array($value, $productsIds)) {
                        array_push($productsIds, $value);
                    }
                }
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
            ->whereIn('products.id', $productsIds)
            ->select('products.id', 'products.name', 'products.description', 'products.price', 'products.category', 'b.name as brand_name', 'pi.id as image_id')->get();

        $toCompare = [];
        $cost = [];
        foreach ($builds as $buildKey => $build) {
            $toCompare[$buildKey] = [];
            $cost[$buildKey] = 0;
            foreach ($build->toArray() as $key => $value) {
                $toCompare[$buildKey][$key] = $value;

                if (!in_array($key, array("id", "customer", "build_name", "build_access", "created_at", "updated_at"))) {
                    if ($value != Null) {
                        $product = array_search($value, array_column($products->toArray(), 'id'));
                        $toCompare[$buildKey][$key] = $products[$product];
                        $cost[$buildKey] += ($products[$product]->price) ? $products[$product]->price : 0;
                    }
                }
            }
        }

        return view('store.buildCompare', [
            'builds' => $toCompare,
            'cost' => $cost,
            'parents' => $parentsData,
            'children' => $children
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Build::findOrFail($id);
        return view('builds.edit', compact('data'));
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
            'components'  => 'required',
            'build_name'  => 'required',
            'build_access'  => 'required|in:private,public',
        ]);
        $build = Build::findOrFail($id);
        $build->name = $request->name;
        $build->name_ar = $request->name_ar;
        if (isset($request->sortOrder)) {
            $build->sortOrder = $request->sortOrder;
        }
        $build->save();
        return redirect('store/builds')->with('success', 'Build Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $build = Build::findOrFail($id);
        $build->delete();
        return redirect('store/builds')->with('success', 'Build Updated Successfully');
    }
}
