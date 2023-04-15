<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\ShippingInfo;
use App\Models\Transaction;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }
    public function paynow($orderId)
    {
        $order = Order::find($orderId);
        $customerInfo = User::find($order->customer_id);
        $shippingInfo = ShippingInfo::with('country', 'state', 'city')->find($order->shipping_id);
        $post_data = array();
        $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        $order->update(['tran_id' => $post_data['tran_id']]);
        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $customerInfo->name;
        $post_data['cus_email'] = $customerInfo->email;
        $post_data['cus_add1'] = !empty($customerInfo->address) ? $customerInfo->address : $shippingInfo->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = !empty($shippingInfo->city) ? $shippingInfo->city->name : '';
        $post_data['cus_state'] = !empty($shippingInfo->state) ? $shippingInfo->state->name : '';
        $post_data['cus_postcode'] = $shippingInfo->postal_code;
        $post_data['cus_country'] = !empty($shippingInfo->country) ? $shippingInfo->country->name : '';
        $post_data['cus_phone'] = $customerInfo->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $shippingInfo->shipping_type;
        $post_data['ship_add1'] = !empty($customerInfo->address) ? $customerInfo->address : $shippingInfo->address;;
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = !empty($shippingInfo->city) ? $shippingInfo->city->name : '';
        $post_data['ship_state'] = !empty($shippingInfo->state) ? $shippingInfo->state->name : '';
        $post_data['ship_postcode'] = $shippingInfo->postal_code;
        $post_data['ship_country'] = !empty($shippingInfo->country) ? $shippingInfo->country->name : '';
        $post_data['ship_phone'] = $customerInfo->mobile;
        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "null";
        $post_data['product_category'] = "null";
        $post_data['product_profile'] = "null";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

//        if (!is_array($payment_options)) {
//            print_r();
//            $payment_options = array();
//        }
        return $payment_options;
    }

    public function success(Request $request)
    {
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $tran_id = $request->input('tran_id');

        $sslc = new SslCommerzNotification();
        $this->makeTransaction($request);
        #Check order status in order tabel against the transaction id or order id.
        $order_details = Order::where('tran_id', $tran_id)
            ->select('tran_id', 'payment_status', 'grand_total')->first();
        if ($order_details->payment_status == 'unpaid') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = Order::where('tran_id', $tran_id)
                    ->update(['payment_status' => 'paid']);
                return redirect()->route('payment_success',encrypt($tran_id));
            }
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Order::where('tran_id', $tran_id)
            ->select('tran_id', 'payment_status', 'grand_total')->first();
        $this->makeTransaction($request);
        if ($order_details->payment_status == 'unpaid') {
            $update_product = Order::where('tran_id', $tran_id)
                ->update(['payment_status' => 'failed']);
            return redirect()->route('payment_failed',encrypt($tran_id));
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = Order::where('tran_id', $tran_id)
            ->select('tran_id', 'payment_status', 'grand_total')->first();
        $this->makeTransaction($request);
        if ($order_details->status == 'unpaid') {
            $update_product = Order::where('tran_id', $tran_id)
                ->update(['payment_status' => 'canceled']);
            return redirect()->route('payment_canceled',encrypt($tran_id));
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = Order::where('tran_id', $tran_id)
                ->select('tran_id', 'payment_status', 'grand_total')->first();
            $this->makeTransaction($request);
            if ($order_details->payment_status == 'unpaid') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = Order::where('tran_id', $tran_id)
                        ->update(['payment_status' => 'paid']);
                    return redirect()->route('payment_success');
                }
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

    private function makeTransaction($request)
    {
        $trasation['tran_id'] = $request->tran_id;
        $trasation['store_id'] = $request->store_id;
        $trasation['status'] = $request->status;
        $trasation['amount'] = $request->amount;
        $trasation['card_type'] = $request->card_type;
        $trasation['card_no'] = $request->card_no;
        $trasation['store_amount'] = $request->store_amount;
        $trasation['bank_tran_id'] = $request->bank_tran_id;
        $trasation['currency'] = $request->currency;
        $trasation['tran_date'] = $request->tran_date;
        return Transaction::create($trasation);
    }
}
