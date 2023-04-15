<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Http\Controllers\Backend;

use Auth;
use Hash;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Visitor;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {

        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Admin::with('role')->latest();
        $query->whereLike($request->field_name, $request->value);

        if ($request->allData) {
            return $query->get();
        } else {
            $datas = $query->paginate($request->pagination);
            return new Resource($datas);
        }
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
            $res = Admin::create($request->all());
            return $this->responseReturn("create", $res);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Admin $admin)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        if (Auth::guard('admin')->user()->role_id == 1) {
            return Admin::with('role')->find($admin->id);
        }
        return Admin::with('role')->find(Auth::guard('admin')->user()->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $ex       = explode('storage/', $admin->profile);
        $oldImage = $ex[1] ?? "";
        if (!empty($request->file('profile'))) {
            if (Storage::disk('public')->exists($oldImage)) :
                Storage::delete($ex[1]);
            endif;
            $imgPath = Storage::putFile('upload/profile', $request->file('profile'));
        }
        $arr = [
            'name'    => $request->name,
            'role_id' => $request->role_id ?? $admin->role_id,
            'mobile'  => $request->mobile,
            'profile' => $imgPath ?? $oldImage,
        ];
        $admin->update($arr);

        return $this->responseReturn("update", $admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $res = $admin->update(['status' => 'deactive']);

        return $this->responseReturn("delete", $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function checkOldPassword(Request $request)
    {
        if (empty($request->for_delete)) {
            if (Auth::guard('admin')->user()->role_id == 1 && Auth::guard('admin')->user()->id != $request->id) {
                return response()->json(true);
            }
        }
        if (Auth::guard('admin')->validate(['password' => $request->old_password, 'id' => $request->id])) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    //password change==============
    public function passwordChange(Request $request)
    {
        $request->validate([
            'new_password'     => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);
        $password = Hash::make($request->new_password);
        Admin::where('id', $request->id)->update(['password' => $password]);
        return response()->json(['message' => 'Password change successfully!!'], 200);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request)
    {
        return $request->validate([
            'name'     => 'required',
            'email'    => 'required|min:2|unique:admins',
            'password' => 'required|min:6',
            'role_id'  => 'required',
        ]);
    }

    public function AdminOrderStatistics()
    {
        $statistics['total_sale_uf'] = Sale::sum('grand_total') + Order::sum('grand_total');
        $statistics['total_sale']=number_format((float)$statistics['total_sale_uf'],2,'.','');
        $statistics['total_order'] = Order::count('id') + Sale::count('id');
        $statistics['total_customer'] = Order::distinct()->count('customer_id') + Sale::distinct()->count('customer_id');
        $statistics['total_products'] = Product::count('id');
        $statistics['unpaid_order'] = Order::where('payment_status', 'unpaid')->count();
        $statistics['paid_order'] = Order::where('payment_status', 'paid')->count();
        $statistics['delivered_order'] = Order::where('order_status', 'delivered')->count();
        $statistics['holding_order'] = Order::where('order_status', '!=', 'delivered')->count();
        $statistics['pos_invoice'] = Sale::select('invoice_id')->count();
        $statistics['visitors'] = Visitor::sum('count');


        return response()->json($statistics);
    }
    public function AdminOrderReport()
    {
        $order = Order::with(['customer' => function ($customer) {
            $customer->select('id', 'name');
        }])->take(10)->get();


        return response()->json($order);
    }
//    Admin POS Order Report
    public function AdminPosOrderReport()
    {
        $orderPos = Sale::take(10)->get();


        return response()->json($orderPos);
    }
    // Admin Month Chart Data
    public function AdminMonthChart()
    {
        $chart['pos_invoice'] = Sale::select('invoice_id')->whereMonth('created_at',Carbon::now()->month)->count();
        $chart['site_invoice'] = Order::select('invoice_id')->whereMonth('created_at',Carbon::now()->month)->count();
        $chart['current_date']=Carbon::now()->format('F-Y');
        return response()->json($chart);
    }

}
