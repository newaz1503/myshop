<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Shipping;
use App\Models\ShippingInfo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Shipping::latest();
        $query->whereLike($request->field_name, $request->value);

        $datas = $query->paginate($request->pagination);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $res = Shipping::create($request->all());
                return $this->responseReturn("create", $res);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    public function storeShippingInfo(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
        ]);

        try {
            if ($request->user_id == 0){
                $userData = $request->except('user_id');
                $user = User::create($userData);
                $shippingInfo = [
                    'user_id' => $user->id,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'mobile' => $request->mobile,
                ];
                $shipping = ShippingInfo::create($shippingInfo);
                return response()->json(['message' => 'Customer Added Successfully!','user_id' => $user->id,'shipping_id'=>$shipping->id], 200);
            }else{
                $shippingInfo = [
                    'user_id' => $request->user_id,
                    'country_id' => $request->country_id,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'mobile' => $request->mobile,
                ];
                ShippingInfo::create($shippingInfo);
                return response()->json(['message' => 'Address Successfully!'], 200);
            }
        } catch (Exception $ex) {
            return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
        }
    }

    public function getShippingInfo(Request $request)
    {
        $shippingAddress = ShippingInfo::with('country','state','city')
            ->where('user_id',$request->user_id)->get();
        return response()->json($shippingAddress);
    }
    public function getCustomerShippingInfo($id)
    {
        $shippingAddress = ShippingInfo::with('customer','country','state','city')->find($id);
        return response()->json($shippingAddress);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shipping $shipping)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $shipping;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        if ($this->validateCheck($request, $shipping->id)) {
            try {
                $data = $request->all();
                $shipping->fill($data)->save();

                return $this->responseReturn("update", $shipping);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroyShippingInfo(Request $request)
    {
        $shippingInfo = ShippingInfo::findOrFail($request->shipping_id);
        $shippingInfo->delete();
        return response()->json(['message' => 'Removed Successfully!'], 200);
    }
    public function destroy(Shipping $shipping)
    {
        $res = $shipping->delete();
        return $this->responseReturn("delete", $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return true;
        return $request->validate([
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ], [
            //ex: 'name' => "This name is required" (custom message)
        ]);
    }
}
