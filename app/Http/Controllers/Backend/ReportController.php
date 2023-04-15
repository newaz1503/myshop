<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\Constraint\Count;

class ReportController extends Controller
{
    // get Top Sale Product

    public function topsale(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $top_selling_products = Product::select('products.id', 'products.name', 'products.featured_image', DB::raw('COUNT(sale_details.id) as sale_count'))
            ->Join('sale_details', 'products.id', '=', 'sale_details.product_id')
            ->groupBy('products.id', 'products.name', 'products.featured_image',)
            ->orderByDesc('sale_count')
            ->take(10)
            ->get();
        //
        return response()->json($top_selling_products);
    }

    public function datewisessales(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $sale_report = SaleDetails::select(
            DB::raw('DATE_FORMAT(sale_details.created_at, "%d %M %y") as day'),
            DB::raw('COUNT(sale_details.sale_id) as sale_count'),
            DB::raw('SUM(sale_details.total_price) as total_sale')
        )
            ->groupBy('day')
            ->orderByDesc('day')
            ->get();
        return response()->json($sale_report);
    }
    public function unpaidcustomers(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $top_selling_products = Order::select(
            'orders.id',
            'orders.customer_id',
            'orders.payment_status',
            'orders.invoice_id',
            'orders.grand_total',
            'users.name',
            'users.mobile',
            DB::raw('DATE_FORMAT(orders.created_at, "%d %M %y") as day')
        )
            ->where('orders.payment_status', 'unpaid')
            ->Join('users', 'orders.customer_id', '=', 'users.id')
            ->take(10)
            ->get();
        return response()->json($top_selling_products);
    }
    public function customertypewisesale(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $customers = array();
        $customers['registered'] = Order::select('orders.id', 'orders.invoice_id', 'orders.grand_total', 'orders.customer_id', 'users.name', 'users.mobile')
            ->Join('users', 'orders.customer_id', '=', 'users.id')
            ->get();
        $customers['walking'] = Sale::select(
            'sales.invoice_id',
            'sales.barcode',
            'sales.grand_total',
            DB::raw('DATE_FORMAT(sales.created_at, "%d %M %y") as day')
        )
            ->where('sales.customer_id', '0')
            ->get();
        $customers['registered_orders'] = Order::count('customer_id');
        $customers['registered_orders_sale'] = Sale::where('customer_id', '!=', '0')->count('customer_id');
        $customers['walking_orders'] = Sale::select('invoice_id')->where('customer_id', '0')->count();
        $customers['registered_sale_amount'] = Order::select(DB::raw('SUM(grand_total) as registered_sale'))->get();

        $customers['registered_pos_amount'] = Sale::select(DB::raw('SUM(grand_total) as registered_sale'))->where('customer_id', '!=', '0')->get();

        $customers['walking_pos_amount'] = Sale::select(DB::raw('SUM(grand_total) as walking_sale'))->where('customer_id', '0')->get();
        return response()->json($customers);
    }
}
