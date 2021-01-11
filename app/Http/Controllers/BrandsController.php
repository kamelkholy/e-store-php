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
            'sortOrder'  => 'integer',
            'image' => 'required|image|max:2048'
        ]);

        $image_file = $request->image;

        $image = Image::make($image_file);

        Response::make($image->encode('jpeg'));
        $form_data = array(
            'name'  => $request->name,
            'image' => $image,
            'sortOrder' => $request->sortOrder,
        );
        // dd($form_data);
        try {
            Brand::create($form_data);
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);
            // Return the response to the client..
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
        try {
            $image = Brand::findOrFail($id);

            $image_file = Image::make($image->image);

            $response = Response::make($image_file->encode('jpeg'));

            $response->header('Content-Type', 'image/jpeg');
        } catch (\Exception $e) {
            dd($e);
        }
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
        $data = Brand::where('id', $id)->orderBy('sortOrder')->get();;
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

        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->sortOrder = $request->sortOrder;

        if (isset($request->image)) {

            $image_file = $request->image;

            $image = Image::make($image_file);

            Response::make($image->encode('jpeg'));
            $brand->image = $image;
        }

        try {
            $brand->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);
            // Return the response to the client..
        }

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
        $brand = Brand::find($id);

        $brand->delete();
        return redirect('/brands')->with('success', 'Brand Updated Successfully');
    }
}
