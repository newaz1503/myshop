<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Models\AttributeValue;
use Exception;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query  = Attribute::with('values')->latest();
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
                $values = $request->values;
                $data = $request->only('name','status','sorting');
                $res = Attribute::create($data);
                if ($res && !empty($values)){
                    foreach ($values as $value){
                        $attValue['attribute_id'] = $res->id;
                        $attValue['value'] = $value;
                        AttributeValue::create($attValue);
                    }
                }
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Attribute $attribute)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $defaultValues  = AttributeValue::where('attribute_id',$attribute->id)->get();
        $values = [];
        foreach ($defaultValues as $defaultValue) {
            if (!empty($defaultValue['value'])){
                array_push($values,$defaultValue['value']);
            }
        }
        $attribute['values'] = $values;
        return $attribute;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        if ($this->validateCheck($request, $attribute->id)) {
            try {
                $values = $request->values;
                $data = $request->only('name','status','sorting');
                $res = $attribute->fill( $data )->save();
                if ($res && !empty($values)){
                    AttributeValue::where('attribute_id',$attribute->id)->delete();
                    foreach ($values as $value){
                        $attValue['attribute_id'] = $attribute->id;
                        $attValue['value'] = $value;
                        AttributeValue::create($attValue);
                    }
                }
                return $this->responseReturn( "update", $attribute);
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $res = $attribute->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id=null)
    {
        return true;
        return $request->validate([
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ],[
            //ex: 'name' => "This name is required" (custom message)
        ]);
    }
}
