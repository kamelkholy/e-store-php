<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Tag())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Tag::sortable()->paginate(10)->withQueryString();
        }

        return view('tags.list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
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
        ]);

        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        Tag::create($form_data);
        return redirect()->back()->with('success', 'Tag Created Successfully');
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
        $data = Tag::findOrFail($id);
        return view('tags.edit', compact('data'));
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
        ]);
        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->name_ar = $request->name_ar;
        if (isset($request->sortOrder)) {
            $tag->sortOrder = $request->sortOrder;
        }
        $tag->save();
        return redirect('/tags')->with('success', 'Tag Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect('/tags')->with('success', 'Tag Updated Successfully');
    }
}
