<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category::with('parent','subCategories')->latest();
        $query->whereLike($request->field_name, $request->value);

        $datas = $query->paginate($request->pagination);
        return new Resource($datas);
    }


    public function categoryList()
    {
        $categories = Category::select('id','title','image','status','parent_id')
            ->whereNull('parent_id')
            ->where('status','active')
            ->get();
        return response()->json( $categories );
    }
    public function subCategoryList($id)
    {
        $subCategories = Category::select('id','title','image','status','parent_id')
            ->where('parent_id',$id)
            ->where('status','active')
            ->get();
        return response()->json( $subCategories );
    }
    public function childCategoryList($id)
    {
        $childCategories = Category::select('id','title','image','status','parent_id')
            ->where('sub_category_id',$id)
            ->where('status','active')
            ->get();
        return response()->json( $childCategories );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend_app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $data = $request->all();
                $image = $request->file('image');
                if (!empty('image')) {
                    $data['image'] = $this->upload($image, 'category');
                } else {
                    $data['image'] = null;
                }
                $res = Category::create($data);
                return $this->responseReturn("create", $res);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $category)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if ($this->validateCheck($request, $category->id)) {
            try {
                $data = $request->all();
                $image = $request->file('image');
                if (!empty($image)) {
                    $data['image'] = $this->upload($image, 'category', $category->image);
                } else {
                    $data['image'] = $this->oldFile($category->image);
                }
                $category->fill($data)->save();
                return $this->responseReturn("update", $category);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->deleteFile($category->image);
        $res = $category->delete();
        return $this->responseReturn("delete", $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate([
            'title' => 'required',
            'sorting' => 'required',
            'status' => 'required',
        ]);
    }
}
