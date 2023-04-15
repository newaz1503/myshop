<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query  = Brand::latest();
        $query->whereLike( $request->field_name, $request->value );

        $datas  = $query->paginate($request->pagination);
        return new Resource($datas);
    }

    public function brandList()
    {
        $brands = Brand::select('id','name','status')->where('status','active')->get();
        return response()->json( $brands );
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $data = $request->all();
                $icon = $request->file('icon');
                if (!empty('icon')) {
                    $data['icon'] = $this->upload($icon, 'brand');
                } else {
                    $data['icon'] = null;
                }
                $res = Brand::create($data);
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Brand $brand)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $brand;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        if ($this->validateCheck($request, $brand->id)) {
            try {
                $data = $request->all();
                $icon = $request->file('icon');
                if (!empty($icon)) {
                    $data['icon'] = $this->upload($icon, 'brand', $brand->icon);
                } else {
                    $data['icon'] = $this->oldFile($brand->icon);
                }
                $brand->fill( $data )->save();
                return $this->responseReturn( "update", $brand );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $this->deleteFile($brand->icon);
        $res = $brand->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id=null)
    {
        return $request->validate([
            'name' => 'required',
            'sorting' => 'required',
            'status' => 'required',
        ]);
    }
}
