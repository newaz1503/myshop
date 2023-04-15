<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripePaymentController extends Controller
{

    public function getStripeSession($orderId)
    {
        $order = Order::find($orderId);
        $orderdetails = OrderDetails::with('product')->select('id','order_id','product_id','quantity','price')
            ->where('order_id', $orderId)->get();
        $lineItems = array();
        $tran_id = uniqid();
        $order->update(['tran_id' => $tran_id]);
        foreach ($orderdetails as $orderdetail){
                $lineItems[] =  [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $orderdetail['price']*100,
                        'product_data' => [
                            'name' =>  $orderdetail['product']['name'],
                            'images' =>  [$orderdetail['product']['featured_image']],
                        ]
                    ],
                    'quantity' => $orderdetail['quantity'],
                ];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $sessionId = $stripe->checkout->sessions->create([
            'success_url' => route('stripe.success',[],true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('stripe.cancel',[],true),
            'line_items' => [
                $lineItems
            ],
            'mode' => 'payment',
        ]);
        return $sessionId;
    }

    public function success(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');
            $tran_id = $request->get('tran_id');
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (empty($session)){
                throw new  NotFoundHttpException();
            }
            $order = Order::where('tran_id',$request->tran_id)->first();
            $order->update(['payment_status' => 'paid']);

            $trasation['tran_id'] = $request->tran_id;
            $trasation['store_id'] = null;
            $trasation['status'] = $session->status;
            $trasation['amount'] = $session->amount_total / 100;
            $trasation['store_amount'] = null;
            $trasation['currency'] = $session->currency;
            $trasation['tran_date'] =  Carbon::now();;
            Transaction::create($trasation);
            return redirect()->route('payment_success',encrypt($request->tran_id));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
