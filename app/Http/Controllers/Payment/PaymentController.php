<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingInfo;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function completePayment(Request $request, $id)
    {
        $trans_id  =  decrypt($id);
        $order = Order::where('tran_id',$trans_id)->first();
        return  redirect()->route('user.viewInvoice',$order->invoice_id);
    }

    public function paymentFailed($id)
    {
        $trans_id  =  decrypt($id);
        $order = Order::where('tran_id',$trans_id)->first();
        return  redirect()->route('user.viewInvoice',$order->invoice_id);
    }
    public function paymentCanceled($id)
    {
        $trans_id  =  decrypt($id);
        $order = Order::where('tran_id',$trans_id)->first();
        return  redirect()->route('user.viewInvoice',$order->invoice_id);
    }
}
