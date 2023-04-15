<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\Payment\SslCommerzPaymentController;
use App\Http\Controllers\Payment\StripePaymentController;
use App\Http\Resources\Resource;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::with('customer')->latest();
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
                $response = array();
                $grand_total = $request->grand_total;
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $invoice_id = $characters[rand(0, strlen($characters) - 1)] . mt_rand(10000, 99999)
                    . $characters[rand(0, strlen($characters) - 1)];
                $user = Auth::user();
                $order_data = $request->except('products', 'total_quantity');
                $order_data['customer_id'] = $user->id;
                $order_data['invoice_id'] = $invoice_id;
                $order_data['total_quantity'] = $request->total_quantity;
                $res = Order::create($order_data);
                $order_id = $res->id;
                $response['order_id'] = $invoice_id;
                if ($res) {
                    foreach ($request->products as $prod) {
                        $product = [
                            'order_id' => $order_id,
                            'product_id' => $prod['id'],
                            'price' => $prod['sale_price'],
                            'quantity' => $prod['quantity'],
                            'discount_amount' => $prod['discount_amount'],
                            'tax_amount' => $prod['tax_amount'],
                            'vat_amount' => $prod['vat_amount'],
                            'total_price' => $prod['total_price'],
                            'variant' => !empty($prod['variant']) ? json_encode($prod['variant']): null,
                        ];
                        OrderDetails::create($product);
                        Product::decrementQty($prod['id'], $prod['quantity']);
                    }
                }
                switch ($request->payment_method) {
                    case "cash_on_delivery":
                        $res->update(['payment_method' => 'cash_on_delivery','payment_status'=> 'paid']);
                        $response['status'] = 'success';
                        $response['go_to_payment'] = url('user/invoice/'.$invoice_id);
                        $response['payment_status'] = 'unpaid';
                        $response['payment_method'] = 'cash_on_delivery';
                        break;
                    case "paypal_payment":
                        $response['status'] = 'success';
                        $response['go_to_payment'] = route('paypal.processTransaction',[],true)."?order_id=". encrypt($order_id);
                        $response['payment_status'] = 'unpaid';
                        $response['payment_method'] = 'paypal_payment';
                        break;
                    case "sslcommerz_payment":
                        $paymentInfo = (new SslCommerzPaymentController())->paynow($res->id);
                        $sslRes = json_decode($paymentInfo, true);
                        $response['status'] = $sslRes['status'];
                        $response['go_to_payment'] = $sslRes['data'];
                        $response['payment_status'] = 'unpaid';
                        $response['payment_method'] = 'sslcommerz_payment';
                        break;
                    case "stripe_payment":
                        $paymentInfo = (new StripePaymentController())->getStripeSession($order_id);
                        $response['go_to_payment'] = $paymentInfo['url'];
                        $response['status'] = 'success';
                        $response['stripeInfo'] = $paymentInfo;
                        $response['payment_status'] = 'unpaid';
                        $response['payment_method'] = 'stripe_payment';
                        break;
                    default:
                        echo "Invalid payment method selected.";
                }

                $response['message'] = 'Your order has been placed successfully';
                $response['total_amount'] = $grand_total;
                return response()->json($response);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Order $order)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        return $order->load(
            'customer',
            'customer.shippingInfo',
            'customer.shippingInfo.country',
            'customer.shippingInfo.city',
            'orderDetails',
            'orderDetails.product'
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if ($this->validateCheck($request, $order->id)) {
            try {
                $data = $request->all();
                $order->fill($data)->save();

                return $this->responseReturn("update", $order);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $res = $order->delete();
        return $this->responseReturn("delete", $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate(
            [
                'grand_total' => 'required',
                'shipping_cost' => 'required',
                'shipping_method_id' => 'required',
                'payment_method' => 'required',
                'sub_total' => 'required',
            ],
            [
                'shipping_method_id.required' => 'Shipping method is required!',
                'payment_method.required' => 'Payment method is required!'
            ]
        );
    }
}
