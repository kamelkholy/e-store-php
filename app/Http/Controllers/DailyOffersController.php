<?php

namespace App\Http\Controllers;

use App\Models\CategoriesLinker;
use App\Models\Category;
use App\Models\Product;
use App\Models\DailyOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new DailyOffer())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = DailyOffer::sortable()->paginate(10)->withQueryString();
        }
        return view('dailyOffers.list', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $products = Product::all('id', 'name');
        return view('dailyOffers.create', ['products' => $products,]);
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
            'date'  => 'required',
            'products'  => 'required',
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d',  $request->date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d',  $request->date)->endOfDay();
        $form_data = array(
            'name'  => $request->name,
            'start_date'  => $startDate,
            'end_date'  => $endDate,
            'products'  => json_encode($request->products),
        );
        DailyOffer::create($form_data);
        return redirect()->back()->with('success', 'DailyOffer Created Successfully');
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
        $data = DailyOffer::findOrFail($id);
        $data->products = ($data->products) ? json_decode($data->products) : [];

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s',  $data->start_date);;
        $data->date = $startDate->toDateString();
        $products = Product::all('id', 'name');

        return view('dailyOffers.edit', ['products' => $products, 'data' => $data]);
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
            'date'  => 'required',
            'products'  => 'required',
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d',  $request->date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d',  $request->date)->endOfDay();
        $products = json_encode($request->products);

        $dailyOffer = DailyOffer::findOrFail($id);
        $dailyOffer->name = $request->name;
        $dailyOffer->start_date = $startDate;
        $dailyOffer->end_date = $endDate;
        $dailyOffer->products = $products;
        $dailyOffer->save();
        return redirect()->route('dailyOffers.index')->with('success', 'DailyOffer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dailyOffer = DailyOffer::findOrFail($id);
        $dailyOffer->delete();
        return redirect()->route('dailyOffers.index')->with('success', 'DailyOffer Updated Successfully');
    }
}
