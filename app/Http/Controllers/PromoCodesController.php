<?php

namespace App\Http\Controllers;

use App\Models\CategoriesLinker;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\PromoCodeOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromoCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = PromoCode::sortable()->paginate(10)->withQueryString();
        $promoUsage = PromoCodeOrder::select('promo_code', DB::raw('count(*) as total'))->groupBy('promo_code')->get();
        foreach ($data as $key => $value) {
            $index = array_search($value->id, array_column($promoUsage->toArray(), 'promo_code'));
            if ($index === false) {
                $value->usage = 0;
            } else {
                $value->usage = $promoUsage[$index]->total;
            }
        }
        return view('promoCodes.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getSubCategories($allSubs, $value, $data = NULL)
    {
        if (!empty($allSubs[$value['id']])) {
            $html = '<ul>';

            $value['subCategories'] = $allSubs[$value['id']];
            foreach ($value['subCategories'] as $key => $sub) {
                $checked = ($data && array_search($sub["id"], $data) !== false) ? "checked" : "";
                $checkData = '<div class="form-check">
                <input name="categories[]" class="form-check-input" type="checkbox" id="' . $sub["id"] . '" value="' . $sub["id"]  . '" ' . $checked . '>
                <label class="form-check-label" for="' . $sub["id"] . '">' . $sub["name"] . '</label></div>';
                $html .= '<li class="list-group-item list-group-item-secondary">' . $checkData . '</li>';
                $value['subCategories'][$key] = $this->getSubCategories($allSubs, $sub, $data);
                if (isset($value['subCategories'][$key]['html'])) {
                    $html .=    $value['subCategories'][$key]['html'];
                }
            }
            $value['html'] = $html . '</ul>';
        }
        return $value;
    }
    public function create()
    {
        $products = Product::all('id', 'name');
        $subCategoires = [];
        $parents = Category::where('level', 0)->orderBy('sortOrder')->get();
        $allCategories = Category::all();
        $links = new CategoriesLinker();
        $links = $links->getChildren(([]));
        foreach ($allCategories as $key => $category) {
            $subCategoires[$category->id] = [];
            foreach ($links as  $link) {
                if ($link->parent == $category->id) {
                    $subCategoires[$category->id][$link->id] = array('id' => $link->categoryId, 'name' => $link->name, 'subCategories' => []);
                }
            }
        }

        $final = [];
        foreach ($parents as $key => $value) {
            $cat = array('id' => $value->id, 'name' => $value->name, 'subCategories' => [], 'html' => '');
            $cat = $this->getSubCategories($subCategoires, $cat);
            array_push($final, $cat);
        }
        return view('promoCodes.create', ['categories' => $final, 'products' => $products,]);
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
            'code'  => 'required',
            'discount'  => 'required',
            'discount_type'  => 'required|in:percentage,ammount',
            'applicability'  => 'required|in:all,some,categories',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);

        switch ($request->applicability) {
            case 'some':
                $request->validate([
                    'products'  => 'required',
                ]);
                break;
            case 'categories':
                $request->validate([
                    'categories'  => 'required',
                ]);
                break;
        }
        $startDate = Carbon::createFromFormat('Y-m-d H:i',  $request->start_date['date'] . ' ' . $request->start_date['time']);;
        $endDate = Carbon::createFromFormat('Y-m-d H:i',  $request->end_date['date'] . ' ' . $request->end_date['time']);;
        $form_data = array(
            'code'  => $request->code,
            'discount'  => $request->discount,
            'discount_type'  => $request->discount_type,
            'applicability'  => $request->applicability,
            'start_date'  => $startDate,
            'end_date'  => $endDate,
        );
        if (isset($request->products)) {
            $form_data['products'] = json_encode($request->products);
        }
        if (isset($request->categories)) {
            $form_data['categories'] = json_encode($request->categories);
        }
        PromoCode::create($form_data);
        return redirect()->back()->with('success', 'PromoCode Created Successfully');
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
        $data = PromoCode::findOrFail($id);
        $data->products = ($data->products) ? json_decode($data->products) : [];
        $data->categories = ($data->categories) ? json_decode($data->categories) : [];

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s',  $data->start_date);;
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $data->end_date);
        $data->start_date = array('date' => $startDate->toDateString(), 'time' => $startDate->toTimeString());
        $data->end_date = array('date' => $endDate->toDateString(), 'time' => $endDate->toTimeString());
        $products = Product::all('id', 'name');
        $subCategoires = [];
        $parents = Category::where('level', 0)->orderBy('sortOrder')->get();
        $allCategories = Category::all();
        $links = new CategoriesLinker();
        $links = $links->getChildren(([]));
        foreach ($allCategories as $key => $category) {
            $subCategoires[$category->id] = [];
            foreach ($links as  $link) {
                if ($link->parent == $category->id) {
                    $subCategoires[$category->id][$link->id] = array('id' => $link->categoryId, 'name' => $link->name, 'subCategories' => []);
                }
            }
        }

        $final = [];
        foreach ($parents as $key => $value) {
            $cat = array('id' => $value->id, 'name' => $value->name, 'subCategories' => [], 'html' => '');
            $cat = $this->getSubCategories($subCategoires, $cat, $data->categories);
            array_push($final, $cat);
        }
        return view('promoCodes.edit', ['categories' => $final, 'products' => $products, 'data' => $data]);
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
            'code'  => 'required',
            'discount'  => 'required',
            'discount_type'  => 'required|in:percentage,ammount',
            'applicability'  => 'required|in:all,some,categories',
            'start_date'  => 'required',
            'end_date'  => 'required',
        ]);

        $products = NULL;
        $categories = NULL;
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s',  $request->start_date['date'] . ' ' . $request->start_date['time']);;
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s',  $request->end_date['date'] . ' ' . $request->end_date['time']);;
        switch ($request->applicability) {
            case 'some':
                $request->validate([
                    'products'  => 'required',
                ]);
                $products = json_encode($request->products);
                break;
            case 'categories':
                $request->validate([
                    'categories'  => 'required',
                ]);
                $categories = json_encode($request->categories);
                break;
        }
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->code = $request->code;
        $promoCode->discount = $request->discount;
        $promoCode->discount_type = $request->discount_type;
        $promoCode->applicability = $request->applicability;
        $promoCode->start_date = $startDate;
        $promoCode->end_date = $endDate;
        $promoCode->products = $products;
        $promoCode->categories = $categories;
        $promoCode->save();
        return redirect('/promoCodes')->with('success', 'PromoCode Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();
        return redirect('/promoCodes')->with('success', 'PromoCode Updated Successfully');
    }
}
