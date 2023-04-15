<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Sale::with('customer')->select('id', 'invoice_id', 'customer_id', 'sub_total', 'total_quantity', 'product_discount', 'invoice_discount', 'shipping_cost', 'grand_total', 'created_at')->latest();
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }
        if ($request->invoice_id) {
            $query->where('invoice_id', 'LIKE', '%' . "{$request->invoice_id}" . '%');
        }
        if ($request->from_date) {
            $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date);
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($request->to_date) {
            $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date);
            $query->whereDate('created_at', '<=', $toDate);
        }
        if ($request->from_date && $request->to_date) {
            $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date);
            $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date);
            $query->whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate);
        }
        $datas = $query->paginate($request->pagination);
        return new Resource($datas);
    }

    public function saleProduct(Request $request)
    {
        $query = Product::select('id', 'name', 'featured_image', 'sale_price', 'quantity', 'tax_amount', 'vat_amount', 'discount_amount')->latest();
        $query->whereLike($request->field_name, $request->value);
        if ($request->product_name) {
            $query->where('name', 'LIKE', '%' . "{$request->product_name}" . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', "{$request->category_id}");
        }
        if ($request->brand_id) {
            $query->where('brand_id', "{$request->brand_id}");
        }
        $datas = $query->paginate($request->pagination);
        return new Resource($datas);
    }

    public function getInvoice($id)
    {
        $invoice = Sale::with(['saleDetails.product', 'customer', 'shippingInfo'])
            ->where('invoice_id', $id)->firstOrFail();
        return response()->json($invoice);
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
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $invoice_id = $characters[rand(0, strlen($characters) - 1)] . mt_rand(10000, 99999)
                    . $characters[rand(0, strlen($characters) - 1)];

                $sale_data = $request->except('products', 'total_quantity');
                $sale_data['invoice_id'] = $invoice_id;
                $sale_data['total_quantity'] = $request->total_quantity;
                $sale_data['barcode'] = mt_rand(1000000, 9999999);
                $res = Sale::create($sale_data);
                if ($res) {
                    foreach ($request->products as $prod) {
                        $product = [
                            'sale_id' => $res->id,
                            'product_id' => $prod['id'],
                            'price' => $prod['sale_price'],
                            'quantity' => $prod['quantity'],
                            'discount_amount' => $prod['discount_amount'],
                            'tax_amount' => $prod['tax_amount'],
                            'vat_amount' => $prod['vat_amount'],
                            'total_price' => $prod['total_price'],
                        ];
                        SaleDetails::create($product);
                        Product::decrementQty($prod['id'], $prod['quantity']);
                    }
                }
                return response()->json(['message' => 'Order Place Successfully!','invoice_id'=>$res->invoice_id], 200);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sale $sale)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        $invoice = $sale->load('saleDetails.product', 'customer', 'shippingInfo');
        return response()->json($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        if ($this->validateCheck($request, $sale->id)) {
            try {
                $data = $request->all();
                $sale->fill($data)->save();

                return $this->responseReturn("update", $sale);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $res = $sale->delete();
        return $this->responseReturn("delete", $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate([
            'customer_id' => 'required',
            'grand_total' => 'required',
            'invoice_discount' => 'required',
            'product_discount' => 'required',
            'shipping_cost' => 'required',
            'shipping_id' => 'required',
            'sub_total' => 'required',
            'tax' => 'required',
            'total_recieve' => 'required',
            'vat' => 'required',
        ],
            [
                'shipping_id.required' => 'Shipping address is required!'
            ]
        );
    }
}
