<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Shipping;
use App\Models\ShippingInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkoutView()
    {
        return view('layouts.frontend_app');
    }

    public function getShippingAddress()
    {
        $user = Auth::user();
        $address =  ShippingInfo::with('customer','country','state','city')->where('user_id', $user->id)->get();
        return response()->json($address);
    }
    public function getShippingMethod()
    {
        $address =  Shipping::get();
        return response()->json($address);
    }
    public function getShippingCost($id)
    {
        $cost =  Shipping::findOrFail($id);
        return response()->json($cost);
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
            $user = Auth::user();
            $shippingInfo = [
                'user_id' => $user->id,
                'user_type' => $request->user_type,
                'shipping_type' => $request->shipping_type,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'mobile' => $request->mobile,
            ];
            ShippingInfo::create($shippingInfo);
            return response()->json(['message' => 'Created Successfully!'], 200);
        } catch (Exception $ex) {
            return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
        }
    }
    public function updateShippingInfo(Request $request,$id)
    {
        $request->validate([
            'country_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'mobile' => 'required',
        ]);

        $shippingData = ShippingInfo::findOrFail($id);

        try {
            $user = Auth::user();
            $shippingInfo = [
                'user_id' => $user->id,
                'user_type' => $request->user_type,
                'shipping_type' => $request->shipping_type,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'mobile' => $request->mobile,
            ];
            $shippingData->update($shippingInfo);
            return response()->json(['message' => 'Update Successfully!'], 200);
        } catch (Exception $ex) {
            return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
        }
    }
    public function destroyShippingInfo(Request $request)
    {
        $shippingInfo = ShippingInfo::findOrFail($request->shipping_id);
        $shippingInfo->delete();
        return response()->json(['message' => 'Removed Successfully!'], 200);
    }

    public function getPaymentMethod()
    {
        $methods = GlobalSetting::select('id','cash_on_delivery','paypal_payment','sslcommerz_payment','stripe_payment','razorpay_payment')->first();
        return response()->json($methods);
    }
}
