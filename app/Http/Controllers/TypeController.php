<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\CategoryHasChildrenException;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        if ($request->query('search_key')) {
            $data = (new Type())->search($request->query('search_key'))->sortable()->paginate(10)->withQueryString();
        } else {
            $data = Type::sortable()->paginate(10)->withQueryString();
        }
        return view('types.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Type::all();
        return view('types.create', compact('cats'));
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
            'specifications'  => 'required',
            'specifications.*.title'  => 'required',
            'specifications.*.type'  => 'required',
            'specifications.*.values'  => 'required',
            'sortOrder'  => 'integer|nullable',
        ]);
        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
            'specifications'  => json_encode($request->specifications),
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }

        $cat = Type::create($form_data);
        return redirect()->back()->with('success', 'Type Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Type::findOrFail($id);
        $data->specifications = json_decode($data->specifications);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Type::findOrFail($id);
        $data->specifications = json_decode($data->specifications);
        return view('types.edit', compact('data'));
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
            'specifications'  => 'required',
            'specifications.*.title'  => 'required',
            'specifications.*.type'  => 'required',
            'specifications.*.values'  => 'required',
            'sortOrder'  => 'integer|nullable',
        ]);
        $type = Type::findOrFail($id);
        $type->name = $request->name;
        $type->name_ar = $request->name_ar;
        $type->specifications = json_encode($request->specifications);

        if (isset($request->sortOrder)) {
            $type->sortOrder = $request->sortOrder;
        }
        $type->save();
        return redirect('/types')->with('success', 'Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return redirect('/types')->with('success', 'Type Deleted Successfully');
    }
}
