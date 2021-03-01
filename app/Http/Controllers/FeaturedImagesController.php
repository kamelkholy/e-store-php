<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\FeaturedImage;
use Image;

class FeaturedImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new FeaturedImage())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = FeaturedImage::sortable()->paginate(10)->withQueryString();
        }
        return view('featuredImages.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('featuredImages.create');
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
        $count = FeaturedImage::count();
        if ($count == 4) {
            return redirect()->back()->withErrors(['message' => "Only Four Images are Allowed"]);
        }
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
        FeaturedImage::create($form_data);
        return redirect()->back()->with('success', 'FeaturedImage Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = FeaturedImage::findOrFail($id);
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
        $data = FeaturedImage::findOrFail($id);
        return view('featuredImages.edit', compact('data'));
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
        $featuredImage = FeaturedImage::findOrFail($id);
        $featuredImage->title = $request->title;
        $featuredImage->sortOrder = $request->sortOrder;

        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $featuredImage->image = $image;
        }

        $featuredImage->save();
        return redirect()->route('featuredImages.index')->with('success', 'FeaturedImage Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $featuredImage = FeaturedImage::findOrFail($id);

        $featuredImage->delete();
        return redirect()->route('featuredImages.index')->with('success', 'FeaturedImage Updated Successfully');
    }
}
