<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CityShipping;

class CityShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = CityShipping::sortable()->paginate(10)->withQueryString();
        return view('cityShippings.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cityShippings.create');
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
            'shipping_fees'  => 'required',
        ]);

        $form_data = array(
            'name'  => $request->name,
            'shipping_fees'  => $request->shipping_fees,
        );

        CityShipping::create($form_data);
        return redirect()->back()->with('success', 'CityShipping Created Successfully');
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
        $data = CityShipping::findOrFail($id);
        return view('cityShippings.edit', compact('data'));
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
            'shipping_fees'  => 'required',
        ]);
        $cityShipping = CityShipping::findOrFail($id);
        $cityShipping->name = $request->name;
        $cityShipping->shipping_fees = $request->shipping_fees;

        $cityShipping->save();
        return redirect('/cityShippings')->with('success', 'CityShipping Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cityShipping = CityShipping::findOrFail($id);
        $cityShipping->delete();
        return redirect('/cityShippings')->with('success', 'CityShipping Updated Successfully');
    }
}
