<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PcBuildSettings;

class PcBuildSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new PcBuildSettings();
        $data = $data->findOrCreate();
        $categories = Category::all('name', 'id');
        return view('pcBuildSettings.form', ['data' => $data, 'categories' => $categories]);
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
        //
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
            'processor' => 'required',
            'motherboard' => 'required',
            'ram' => 'required',
            'primary_storage' => 'required',
            'secondary_storage' => 'required',
            'gpu' => 'required',
            'tower' => 'required',
            'tower_cooler' => 'required',
            'optical_drive' => 'required',
            'cpu_cooler' => 'required',
            'power_supply' => 'required',
            'monitor' => 'required',
            'keyboard' => 'required',
            'mouse' => 'required',
            'headphone' => 'required',

        ]);
        $pcBuildSetting = PcBuildSettings::findOrFail($id);
        $pcBuildSetting->processor = $request->processor;
        $pcBuildSetting->motherboard = $request->motherboard;
        $pcBuildSetting->ram = $request->ram;
        $pcBuildSetting->primary_storage = $request->primary_storage;
        $pcBuildSetting->secondary_storage = $request->secondary_storage;
        $pcBuildSetting->gpu = $request->gpu;
        $pcBuildSetting->tower = $request->tower;
        $pcBuildSetting->tower_cooler = $request->tower_cooler;
        $pcBuildSetting->optical_drive = $request->optical_drive;
        $pcBuildSetting->cpu_cooler = $request->cpu_cooler;
        $pcBuildSetting->power_supply = $request->power_supply;
        $pcBuildSetting->monitor = $request->monitor;
        $pcBuildSetting->keyboard = $request->keyboard;
        $pcBuildSetting->mouse = $request->mouse;
        $pcBuildSetting->headphone = $request->headphone;

        $pcBuildSetting->save();
        return redirect()->route('pcBuildSettings.index')->with('success', 'PcBuildSettings Updated Successfully');
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
