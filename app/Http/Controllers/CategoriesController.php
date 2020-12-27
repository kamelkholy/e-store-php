<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Category;
use App\Models\CategoriesLinker;
use Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\CategoryHasChildrenException;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return view('categories.list', compact('data'));
    }
    public function getForStore()
    {
        $data = Category::where('level', 0)->get();
        $parents = array();
        foreach ($data as $key => $value) {
            array_push($parents, $value->id);
        }
        $childs = CategoriesLinker::whereIn('parent', ($parents))->get();

        return view('categories.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::all();
        return view('categories.create', compact('cats'));
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'image|max:2048'
        ]);
        $form_data = array(
            'name'  => $request->name,
            'sortOrder' => $request->sortOrder,
        );
        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $form_data['image'] = $image;
            $form_data['show_image'] = true;
        }
        if (!($request->parent == "NULL")) {
            $parent = Category::findOrFail($request->parent);
            $form_data['level'] = $parent->level + 1;
            $form_data['parent'] = $parent->id;
            $cat = Category::create($form_data);
            $link = array(
                'parent' => $request->parent,
                'categoryId' => $cat->id,
                'level' => $parent->level + 1
            );
            CategoriesLinker::create($link);
            // $links = CategoriesLinker::where('categoryId', $request->parent)->get();
            // if ($links->isEmpty()) {
            //     $link = array(
            //         'parent' => $request->parent,
            //         'categoryId' => $cat->id,
            //         'level' => $parent->level + 1
            //     );
            //     CategoriesLinker::create($link);
            // } else {
            //     $multiLinks = array();
            //     array_push($multiLinks, array(
            //         'parent' => $request->parent,
            //         'categoryId' => $cat->id,
            //         'level' => $parent->level + 1
            //     ));
            //     foreach ($links as $key => $value) {
            //         # code...
            //         array_push($multiLinks, array(
            //             'parent' => $value->parent,
            //             'categoryId' => $cat->id,
            //             'level' => $parent->level + 1
            //         ));
            //     }
            //     CategoriesLinker::insert($multiLinks);
            // }
        } else {
            $cat = Category::create($form_data);
        }
        return redirect()->back()->with('success', 'Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Category::findOrFail($id);
        if ($image->image) {
            $image_file = Image::make($image->image);
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
        $data = new Category();
        $data = $data->getCategoryWithParent($id);
        if (count($data) == 0) {
            throw new ModelNotFoundException('Invalid ID ' . $id);
        }
        $links = CategoriesLinker::where('parent', $id)->get();

        $excludedCategories = array();
        array_push($excludedCategories, $id);
        if ($data[0]->parent != NULL) {
            array_push($excludedCategories, $data[0]->parent);
        }
        foreach ($links as $key => $value) {
            array_push($excludedCategories, $value->categoryId);
        }
        $cats = Category::whereNotIn('id', ($excludedCategories))->get();
        return view('categories.edit', ['data' => $data, 'cats' => $cats]);
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
            'sortOrder'  => 'integer|nullable',
            'image' => 'image|max:2048'
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->sortOrder = $request->sortOrder;

        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $category->image = $image;
        }
        if (($request->parent == "NULL")) {
            CategoriesLinker::where('parent', $category->parent)->delete();
            $category['level'] = 0;
            $category['parent'] = NULL;
        } else if (!($request->parent == $category->parent)) {
            $parent = Category::findOrFail($request->parent);
            CategoriesLinker::where('parent', $category->parent)->delete();
            $category['level'] = $parent->level + 1;
            $category['parent'] = $parent->id;
            $link = array(
                'parent' => $request->parent,
                'categoryId' => $category->id,
                'level' => $parent->level + 1
            );
            CategoriesLinker::create($link);
        }
        $category->save();
        return redirect('/categories')->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $links = CategoriesLinker::where('parent', $id)->get();
        if (count($links) > 0) {
            throw new CategoryHasChildrenException('Test');
        }
        $category->delete();
        return redirect('/categories')->with('success', 'Category Deleted Successfully');
    }
}
