<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreSettings;
use Image;
use Illuminate\Support\Facades\Response;

class StoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new StoreSettings();
        $data = $data->findOrCreate();
        return view('storeSettings.form', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = StoreSettings::findOrFail($id);
        if ($image->store_logo) {
            $image_file = Image::make($image->store_logo);
            $response = Response::make($image_file->encode('jpeg'));
            $response->header('Content-Type', 'image/jpeg');
            return $response;
        }
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
        //
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
            'flat_shipping'  => 'required',
            'address'  => 'required',
            'email'  => 'required',
            'phone'  => 'required',
        ]);
        $storeSetting = StoreSettings::findOrFail($id);
        $storeSetting->flat_shipping = $request->flat_shipping;
        $storeSetting->address = $request->address;
        $storeSetting->email = $request->email;
        $storeSetting->phone = $request->phone;
        $storeSetting->address = $request->address;
        $storeSetting->store_name = $request->store_name;
        $storeSetting->facebook = $request->facebook;
        $storeSetting->instagram = $request->instagram;
        $storeSetting->linkedin = $request->linkedin;
        $storeSetting->whatsapp = $request->whatsapp;
        $storeSetting->twitter = $request->twitter;
        $storeSetting->youtube = $request->youtube;
        if (isset($request->store_logo)) {
            $image_file = $request->store_logo;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $storeSetting->store_logo = $image;
        }
        $storeSetting->save();
        return redirect()->route('storeSettings.index')->with('success', 'StoreSettings Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
