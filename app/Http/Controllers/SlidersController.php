<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Slider;
use Image;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Slider())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Slider::sortable()->paginate(10)->withQueryString();
        }
        return view('sliders.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sliders.create');
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'required|image|max:2048'
        ]);
        $image_file = $request->image;
        $image = Image::make($image_file);
        Response::make($image->encode('jpeg'));
        $form_data = array(
            'title'  => $request->title,
            'image' => $image,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        Slider::create($form_data);
        return redirect()->back()->with('success', 'Slider Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Slider::findOrFail($id);
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
        $data = Slider::findOrFail($id);
        return view('sliders.edit', compact('data'));
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'image|max:2048'
        ]);
        $slider = Slider::findOrFail($id);
        $slider->title = $request->title;
        $slider->sortOrder = $request->sortOrder;

        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $slider->image = $image;
        }

        $slider->save();
        return redirect()->route('sliders.index')->with('success', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider Updated Successfully');
    }
}
