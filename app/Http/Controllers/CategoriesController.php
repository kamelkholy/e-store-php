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
    protected function getSubCategories($allSubs, $value, $data = NULL)
    {
        if (!empty($allSubs[$value['id']])) {
            $html = '';

            $value['subCategories'] = $allSubs[$value['id']];
            foreach ($value['subCategories'] as $key => $sub) {
                $deleteUrl = route("categories.destroy", [$sub["id"]]);
                $editUrl = route("categories.edit", [$sub["id"]]);
                $token = csrf_token();
                $value['subCategories'][$key] = $this->getSubCategories($allSubs, $sub, $data);
                $expand = count($value['subCategories'][$key]['subCategories']) > 0 ?
                    '<td class="align-middle">
                        <a style="cursor: pointer;" onclick="expandSub(' . $sub['id'] . ')"> <i class="fa fa-plus-circle"></i></a>
                    </td>' :
                    '<td class="align-middle"></td>';
                $rowColor = ($sub['level'] > 1) ? 'table-dark' : 'table-secondary';
                $html .= '
                <tr class="' . $rowColor . ' sub-' . $value['id'] . '" style="display: none;">
                ' . $expand . '
                <td class="align-middle">' . $sub['name'] . '</td>
                <td class="align-middle">' . $sub['name_ar'] . '</td>
                <td class="align-middle">' . $sub['sortOrder'] . '</td>
                <td class="align-middle">
                <form action="' . $deleteUrl . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . $token . '" />
                    <a href="' . $editUrl . '" class="btn-sm btn-secondary" style="padding: .5rem .5rem;"><i class="fa fa-edit"></i></a>
                    <button type="submit" class="btn-sm btn-danger" style="cursor: pointer;"><i class="fa fa-trash"></i></button>
                </form>
            </td>                
                </tr>';
                if (isset($value['subCategories'][$key]['html'])) {
                    $html .=    $value['subCategories'][$key]['html'];
                }
            }
            $value['html'] = $html;
        }
        return $value;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
        $subCategoires = [];
        $parents = Category::where('level', 0)->orderBy('sortOrder')->get();
        $allCategories = Category::all();
        $links = new CategoriesLinker();
        $links = $links->getChildren(([]));
        foreach ($allCategories as $key => $category) {
            $subCategoires[$category->id] = [];
            foreach ($links as  $link) {
                if ($link->parent == $category->id) {
                    $subCategoires[$category->id][$link->id] = array(
                        'id' => $link->categoryId,
                        'name' => $link->name,
                        'name_ar' => $link->name_ar,
                        'level' => $link->level,
                        'sortOrder' => $link->sortOrder,
                        'subCategories' => []
                    );
                }
            }
        }

        $final = [];
        foreach ($parents as $key => $value) {
            $cat = array(
                'id' => $value->id,
                'name' => $value->name,
                'name_ar' => $value->name_ar,
                'level' => $value->level,
                'sortOrder' => $value->sortOrder,
                'subCategories' => [], 'html' => ''
            );
            $cat = $this->getSubCategories($subCategoires, $cat);
            array_push($final, $cat);
        }
        // dd($final);
        return view('categories.list', ['data' => $final]);
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
        $subCategoires = [];
        $cats = Category::where('level', 0)->orderBy('sortOrder')->get();
        $allCategories = Category::all();
        $links = new CategoriesLinker();
        $links = $links->getChildren(([]));
        foreach ($allCategories as $key => $category) {
            $subCategoires[$category->id] = [];
            foreach ($links as  $link) {
                if ($link->parent == $category->id) {
                    $subCategoires[$category->id][$link->id] = array(
                        'id' => $link->categoryId,
                        'name' => $link->name,
                        'name_ar' => $link->name_ar,
                        'level' => $link->level,
                        'sortOrder' => $link->sortOrder,
                        'subCategories' => []
                    );
                }
            }
        }
        return view('categories.create', ['cats' => $cats, 'subs' => $subCategoires]);
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
            'image' => 'image|max:2048'
        ]);
        $form_data = array(
            'name'  => $request->name,
            'name_ar'  => $request->name_ar,
            'description'  => $request->description,
        );
        if (isset($request->sortOrder)) {
            $form_data['sortOrder'] = $request->sortOrder;
        }
        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $form_data['image'] = $image;
            $form_data['show_image'] = true;
        }
        $actualParent = $request->parent;
        if (isset($request->lvl_1) && $request->lvl_1 != "NULL") {
            $actualParent = $request->lvl_1;
        }
        if (isset($request->lvl_2) && $request->lvl_2 != "NULL") {
            $actualParent = $request->lvl_2;
        }
        if (!($actualParent == "NULL")) {
            $parent = Category::findOrFail($actualParent);
            $form_data['level'] = $parent->level + 1;
            $form_data['parent'] = $parent->id;
            $cat = Category::create($form_data);
            $link = array(
                'parent' => $actualParent,
                'categoryId' => $cat->id,
                'level' => $parent->level + 1
            );
            CategoriesLinker::create($link);
            // $links = CategoriesLinker::where('categoryId', $actualParent)->get();
            // if ($links->isEmpty()) {
            //     $link = array(
            //         'parent' => $actualParent,
            //         'categoryId' => $cat->id,
            //         'level' => $parent->level + 1
            //     );
            //     CategoriesLinker::create($link);
            // } else {
            //     $multiLinks = array();
            //     array_push($multiLinks, array(
            //         'parent' => $actualParent,
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
        foreach ($links as $key => $value) {
            array_push($excludedCategories, $value->categoryId);
        }
        $subCategoires = [];
        $cats = Category::where('level', 0)->whereNotIn('id', ($excludedCategories))->orderBy('sortOrder')->get();
        $allCategories = Category::all();
        $links = new CategoriesLinker();
        $links = $links->getChildren(([]));
        foreach ($allCategories as $key => $category) {
            $subCategoires[$category->id] = [];
            foreach ($links as  $link) {
                if ($link->parent == $category->id) {
                    if (!in_array($link->categoryId, $excludedCategories)) {
                        $subCategoires[$category->id][$link->id] = array(
                            'id' => $link->categoryId,
                            'name' => $link->name,
                            'name_ar' => $link->name_ar,
                            'level' => $link->level,
                            'sortOrder' => $link->sortOrder,
                            'subCategories' => []
                        );
                    }
                }
            }
        }
        return view('categories.edit', ['data' => $data, 'cats' => $cats, 'subs' => $subCategoires]);
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
            'image' => 'image|max:2048'
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->name_ar = $request->name_ar;
        $category->description = $request->description;
        if (isset($request->sortOrder)) {
            $category->sortOrder = $request->sortOrder;
        }

        if (isset($request->image)) {
            $image_file = $request->image;
            $image = Image::make($image_file);
            Response::make($image->encode('jpeg'));
            $category->image = $image;
        }
        if (isset($request->parent)) {
            $actualParent = $request->parent;
            if (isset($request->lvl_1) && $request->lvl_1 != "NULL") {
                $actualParent = $request->lvl_1;
            }
            if (isset($request->lvl_2) && $request->lvl_2 != "NULL") {
                $actualParent = $request->lvl_2;
            }
            if (($actualParent == "NULL")) {
                CategoriesLinker::where('categoryId', $category->id)->delete();
                $category['level'] = 0;
                $category['parent'] = NULL;
                $this->fixChildren($category->id, $category['level']);
            } else if (!($actualParent == $category->parent)) {
                if ($actualParent == $id) {
                    return redirect()->back()->withErrors(["message" => "Can't Set Parent As Self"]);
                }
                $parent = Category::findOrFail($actualParent);
                CategoriesLinker::where('categoryId', $category->id)->delete();
                $category['level'] = $parent->level + 1;
                $category['parent'] = $parent->id;
                $this->fixChildren($category->id, $category['level']);
                $link = array(
                    'parent' => $actualParent,
                    'categoryId' => $category->id,
                    'level' => $parent->level + 1
                );
                CategoriesLinker::create($link);
            }
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category Updated Successfully');
    }

    protected function fixChildren($parent, $level)
    {
        $parents = [];
        array_push($parents, $parent);
        $links = CategoriesLinker::where('parent', $parent);
        $linksData = $links->get();
        foreach ($linksData as $key => $value) {
            $lvl2Links = CategoriesLinker::where('parent', $value->categoryId);
            $lvl2Links->update(['level' => $level + 1]);
            Category::whereIn('id', array_column($lvl2Links->get()->toArray(), 'categoryId'))->update(['level' => $level + 1]);
        }
        $links->update(['level' => $level + 1]);
        Category::whereIn('id', array_column($linksData->toArray(), 'categoryId'))->update(['level' => $level + 1]);
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
        return redirect()->route('categories.index')->with('success', 'Category Deleted Successfully');
    }
}
