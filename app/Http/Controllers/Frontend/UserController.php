<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\CampaignOffer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ShippingInfo;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    // Profile
    public function profileInfo()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function Orderstatus()
    {
        $user = Auth::user();
        $statistics['total_order'] = Order::where('customer_id', $user->id)->count();
        $statistics['order_pending'] = Order::where('customer_id', $user->id)->where('order_status', 'pending')->count();
        $statistics['order_cancel'] = Order::where('customer_id', $user->id)->where('order_status', 'cancel')->count();

        return response()->json($statistics);
    }

    public function viewInvoice(Request $request, $id)
    {
        if ($request->format() == 'html') {
            return view('layouts.frontend_app');
        }
        $invoice = Order::with(['orderDetails.product', 'customer'])
            ->where('invoice_id', $id)
            ->first();
        $invoice['shippingInfo'] = ShippingInfo::with('country','state','city')->find($invoice->shipping_id);
        $invoice['billingInfo'] = ShippingInfo::with('country','state','city')->find($invoice->billing_id);
        return response()->json($invoice);
    }

    public function Recentorder()
    {
        $user = Auth::user();
        $orders = Order::with(['orderDetails' => function ($details) {
            $details->select('order_id', 'id', 'total_price', 'product_id');
        }, 'orderDetails.product' => function ($product) {
            $product->select(Product::selectField());
        }])->where('customer_id', $user->id)
            ->where('order_status', '!=', 'cancel')
            ->take(10)
            ->get();
        return response()->json($orders);
    }

    public function Canceledorder()
    {
        $user = Auth::user();
        $canceled_orders = Order::with(['orderDetails' => function ($details) {
            $details->select('order_id', 'id', 'total_price', 'product_id');
        }, 'orderDetails.product' => function ($product) {
            $product->select('id', 'name', 'featured_image');
        }])
            ->where('customer_id', $user->id)->where('order_status', 'cancel')->get();
        // return response()->json($orders);
        return response()->json($canceled_orders);
    }

    public function Profiledetails()
    {
        $user = Auth::user();
        $defaultShippingAddress = ShippingInfo::with('country','state','city')
            ->where('default_shipping', 1)
            ->where('user_id', $user->id)
            ->first();
        $defaultBillingAddress = ShippingInfo::with('country','state','city')
            ->where('default_billing', 1)
            ->where('user_id', $user->id)
            ->first();
        $shippingInfo = ShippingInfo::with(['country' => function ($country_name) {
            $country_name->select('id', 'country_id', 'name');
        }, 'state' => function ($state_name) {
            $state_name->select('id', 'state_id', 'name');
        }, 'city' => function ($city_name) {
            $city_name->select('id', 'name');
        }])
            ->where('user_id', $user->id)
            ->get();
        return response()->json([
            'profileInfo' => $user,
            'shippingInfo' => $shippingInfo,
            'defaultShipping' => $defaultShippingAddress,
            'defaultBilling' => $defaultBillingAddress,
        ]);
    }

    public function addressMakeDefault(Request $request)
    {
        $user = Auth::user();
        if ($request->default_data == 'default_shipping'){
            $oldShipping = ShippingInfo::where('user_id', $user->id)->where('default_shipping', 1)->first();
            if ($oldShipping){
                $oldShipping->default_shipping = 0;
                $oldShipping->save();
            }
        }
        if ($request->default_data == 'default_billing'){
            $oldBilling = ShippingInfo::where('user_id', $user->id)->where('default_billing', 1)->first();
            if ($oldBilling){
                $oldBilling->default_billing = 0;
                $oldBilling->save();
            }
        }
        // make update
        if ($request->default_data == 'default_shipping'){
            ShippingInfo::where('id', $request->address_id)->update(['default_shipping' => 1]);
        }
        if ($request->default_data == 'default_billing'){
            ShippingInfo::where('id', $request->address_id)->update(['default_billing' => 1]);
        }
        return response()->json(['message' => "Change successfully!"]);
    }

    // get all orders
    public function Allorders(Request $request)
    {
        $user = Auth::user();
        $query = Order::where('customer_id', $user->id)->latest();
        $query->whereLike($request->field_name, $request->value);
        if (!empty($request->from_date) && $request->to_date){
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }
        $datas = $query->paginate($request->pagination);
        return new Resource($datas);
    }

    public function Wishlistdetails()
    {
        $user = Auth::user();
        $wishlist_products = Wishlist::with('product')->where('user_id', $user->id)->get();
        return response()->json($wishlist_products);
    }

    public function DeleteFromWishlist($wishlist_id)
    {
        $user = Auth::user();
        Wishlist::where('id', $wishlist_id)->where('user_id', $user->id)->delete();
        return response()->json(['success' => true]);
    }

    // Delete Order
    public function DeleteOrder($order_id)
    {
        $user = Auth::user();
        $orders = Order::where('id', $order_id)->where('customer_id', $user->id)->delete();
        return response()->json(['success' => true]);
    }

    // Update user Profile
    public function UpdateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
        ]);
        try {
            $user = Auth::user();
            $data = $request->all();
            $avatar = $request->file('avatar');
            if (!empty($avatar)) {
                $data['avatar'] = $this->upload($avatar, 'user', $user->avatar);
            } else {
                $data['avatar'] = $this->oldFile($user->avatar);
            }
            $user->update($data);
            return response()->json(['success' => 'Profile updated successfully']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

//

        $update['userInfo'] = User::where('id', $user->id)->update($userInfo);
        $update ['shippingInfo'] = ShippingInfo::where('user_id', $user->id)->update($shippingInfo);
        $update ['billingInfo'] = User::where('id', $user->id)->update($billingInfo);
        if ($update) {
            return response()->json(['success' => true]);
        }
    }

    // Track order for user
    public function TrackOrder(Request $request)
    {
        $user = Auth::user();
        $invoice = $request->invoice;
        $track_report = Order::where('customer_id', $user->id)->where('invoice_id', $invoice)->first();
        if ($track_report) {
            return response()->json($track_report);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // Update Review
    public function AddRatingReview(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data['user_id'] = $user->id;
        $data['product_id'] = $request->product_id;
        $data['rating'] = $request->rating;
        $data['comment'] = $request->comment;
        $check = ProductReview::where('user_id', $user->id)->where('product_id', $data['product_id'])->first();
        if ($check) {
            return response()->json(['exists' => true]);
        } else {
            $update = ProductReview::create($data);
            if ($update) {
                return response()->json(['success' => true]);
            }
        }
    }

    // get review stats
    public function GetProductReview(Request $request, $id)
    {
        $review['all_review'] = ProductReview::select('user_id', 'rating', 'product_id', 'comment', DB::raw('DATE_FORMAT(product_reviews.created_at, "%d %M %y") as day'))->with('user')->where('product_id', $id)->get();
        $avg_rating = ProductReview::where('product_id', $id)->avg('rating');
        $review['avg_rating'] = round($avg_rating, 1);
        $review['total_reviews'] = ProductReview::where('product_id', $id)->count('id');

        return response()->json($review);
    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'old_password' =>'required',
            'new_password'     => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);
        $user = Auth::user();
        if ($user) {
            $current_password = $request->old_password;
            $new_password = $request->new_password;
            $confirm_password = $request->confirm_password;
            $checkpassword = Hash::check($current_password, Auth()->user()->password);
            if ($checkpassword) {
                User::find($user->id)->update(['password' => Hash::make($confirm_password)]);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function CampaignDetails(Request $request, $id)
    {


        $res = CampaignOffer::select('id', 'title', 'last_date', 'status', 'products')
            ->where('id', $id)
            ->oldest('sorting')->get();
        return response()->json($res);
    }
}
