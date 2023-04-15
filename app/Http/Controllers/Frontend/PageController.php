<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StoreSetting;

class PageController extends Controller
{
    // All Products Pages
    public function allProducts(Request $request)
    {
        $query = Product::select(Product::selectField())->latest();
        $params = json_decode($request->query_params, true);
        if (!empty($request->product_name)) {
            $query->where('name', 'LIKE', '%' . $request->product_name . '%');
        }
        if (!empty($params['category'])) {
            $category = Category::where('slug', $params['category'])->first();
            $query->where('category_id', $category->id);
        }
        if (!empty($params['brand'])) {
            $brand = Brand::where('slug', $params['brand'])->first();
            $query->where('brand_id', $brand->id);
        }
        if (!empty($request->brand_id)) {
            $query->whereIn('brand_id', $request->brand_id);
        }
        if (!empty($request->from_price) && !empty($request->to_price)) {
            $query->whereBetween('sale_price', [$request->from_price, $request->to_price]);
        }
        $products = $query->get();
        $total = $query->count();
        return response()->json(['products' => $products, 'countProduct' => $total]);
    }


    // Prodcut Details
    public function productDetails($slug)
    {
        $variantAttributes = Attribute::get()->toArray();
        $product = Product::with(['category', 'brand', 'variantProduct'])->where('slug', $slug)->firstOrFail();
        $variants = array();
        foreach ($variantAttributes as $variantAttribute) {
            foreach ($product['variantProduct'] as $key => $variant) {
                if ($variant['attribute_name'] == $variantAttribute['name']) {
                    $variants[$variantAttribute['name']][] = [
                        'value' => $variant['attribute_value'],
                        'stock' => $variant['stock'],
                        'image' => $variant['image'],
                        'price' => $variant['price'],
                    ];
                }
            }
        }
        $product['variantProduct'] = $variants;
        return response()->json($product);
    }

    public function allbrand()
    {
        $brands = Brand::where('status', 'active')->get();
        return response()->json($brands);
    }

    public function allcategories()
    {
        $categories = Category::where('status', 'active')->get();
        return response()->json($categories);
    }

    public function getPageContent($slug)
    {
        $page_content = Page::where('slug', $slug)->first();
        return response()->json($page_content);
    }

    public function allfaq(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.frontend_app');
        }
        $faqs = Faq::where('status', 'active')->latest()->get();
        return response()->json($faqs);
    }

    public function about(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.frontend_app');
        }
        $about = Page::latest()->first();
        return response()->json($about);
    }

    public function allCoupons(Request $request)
    {
        if ($request->format() == 'html') {
            return view('layouts.frontend_app');
        }
        $todayDate = date('Y-m-d');
        $coupons = Coupon::where('status', 'active')->where('expire_date', '>=', $todayDate)->oldest('expire_date')->get();
        foreach ($coupons as $coupon) {
            if (!empty($coupon['products'])) {
                $coupon['products'] = Product::select(
                    'id',
                    'name',
                    'slug',
                    'discount_amount',
                    'featured_image',
                    'discount_type',
                    'purchase_price',
                    'quantity',
                    'sale_price',
                    'rating'
                )
                    ->whereIn('id', json_decode($coupon['products'], true))
                    ->get();
            }
        }
        return response()->json($coupons);
    }

    public function couponApply(Request $request)
    {
        $todayDate = date('Y-m-d');
        $coupon = Coupon::select('id', 'coupon_type', 'title', 'code', 'discount_type', 'discount_amount', 'expire_date', 'status', 'products', 'minimum_order_amount')
            ->where('status', 'active')
            ->where('code', $request->coupon_code)
            ->where('expire_date', '>=', $todayDate)
            ->first();
        $response = array();
        if (!empty($coupon)) {
            if ($coupon->coupon_type == 'for_products') {
                $products = Product::whereIn('id', $request->verifyFields['products'])->get();
                if (!empty($products)) {
                    $response = [
                        'find_product' => true,
                    ];
                } else {
                    $response = [
                        'find_product' => false,
                        'error' => 'Product not available',
                    ];
                }
            } else if ($coupon->coupon_type == 'for_total_orders') {
                if ($request->verifyFields['totalAmount'] >= $coupon->minimum_order_amount) {
                    $response = [
                        'order_amount_match' => true,
                    ];
                } else {
                    $response = [
                        'order_amount_match' => false,
                        'error' => "Coupon requirements doesn't match!",
                    ];
                }
            }
            return response()->json(['coupon' => $coupon, 'response' => $response], 200);
        } else {
            return response()->json(['error' => 'This Coupon does not match!'], 404);
        }
    }


    public function sectionWiseProducts(Request $request, $slug)
    {
        if ($request->format() == 'html') {
            return view('layouts.frontend_app');
        }
        if ($slug == 'section-one-product') {
            $section = StoreSetting::select('id', 'section_one_products')->first();
            $products  = Product::select(Product::selectField())
                ->whereIn('id', json_decode($section->section_one_products, true))->get();
            return response()->json($products, 200);
        } else if ($slug == 'section-two-product') {
            $section = StoreSetting::select('id', 'section_two_products')->first();
            $products  = Product::select(Product::selectField())
                ->whereIn('id', json_decode($section->section_two_products, true))->get();
            return response()->json($products, 200);
        } else if ($slug == 'section_three_products') {
            $section = StoreSetting::select('id', 'section_three_products')->first();
            $products  = Product::select(Product::selectField())
                ->whereIn('id', json_decode($section->section_three_products, true))->get();
            return response()->json($products, 200);
        }
    }
}
