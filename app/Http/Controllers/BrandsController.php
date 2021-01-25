<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Brand;
use Image;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = Brand::sortable()->paginate(10)->withQueryString();
        return view('brands.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'required|image|max:2048'
        ]);
        $image_file = $request->image;
        $image = Image::make($image_file);
        Response::make($image->encode('jpeg'));
        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
            'image' => $image,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        try {
            //code...
            Brand::create($form_data);
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
        return redirect()->back()->with('success', 'Brand Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Brand::findOrFail($id);
        $image_file = Image::make($image->image);
        $response = Response::make($image_file->encode('jpeg'));
        $response->header('Content-Type', 'image/jpeg');
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Brand::findOrFail($id);
        return view('brands.edit', compact('data'));
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'required|image|max:2048'
        ]);
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->name_ar = $request->name_ar;
        $brand->sortOrder = $request->sortOrder;

        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $brand->image = $image;
        }

        $brand->save();
        return redirect('/brands')->with('success', 'Brand Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();
        return redirect('/brands')->with('success', 'Brand Updated Successfully');
    }
}
