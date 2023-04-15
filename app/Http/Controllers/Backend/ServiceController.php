<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use Exception;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use App\Http\Controllers\Controller;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query  = Service::latest();
        $query->whereLike( $request->field_name, $request->value );

        $datas  = $query->paginate($request->pagination);
        return new Resource($datas);
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
                $file = $request->file( 'image' );
                if ( !empty( $file ) ) {
                    $data['image'] = $this->upload( $file, 'news' );
                }
                $res = Service::create($data);
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Service $service)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $service;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        if ($this->validateCheck($request, $service->id)) {
            try {
                $data = $request->all();
                $file = $request->file( 'image' );

                if ( !empty( $file ) ) {
                    $data['image'] = $this->upload( $file, 'news', $service->image );
                } else {
                    $data['image'] = $this->oldFile( $service->image );
                }
                $service->fill( $data )->save();

                return $this->responseReturn( "update", $service );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $res = $service->delete();
        $this->deleteFile($service->image);
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
            'title' => 'required',
            'sorting' => 'required',
            'description' => 'required',
        ]);
    }
}
