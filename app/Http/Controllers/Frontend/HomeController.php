<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CampaignOffer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\StoreSetting;
use App\Models\Website\Gallery\Slider;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**======MENUS======**/
    public function menus()
    {
        return [
            "menus" => App::make('frontMenuObj'),
            "config" => App::make('siteSettingObj'),
        ];
    }

    /**======WEBSITE HOME PAGE======**/
    public function homePage()
    {
        return App::make('websiteObj');
    }


    public function home(Request $request)
    {
        $ip = $request->getClientIp();
        // Check if the IP address exists in the visitors table
        $visitor = DB::table('visitors')->where('ip_address', $ip)->first();
        // If the IP address does not exist, add a new record
        if (!$visitor) {
            DB::table('visitors')->insert([
                'ip_address' => $ip,
                'count' => 1,
            ]);
        }
        // If the IP address exists, increment the count
        else {
            DB::table('visitors')->where('ip_address', $ip)->increment('count');
        }
        return view('layouts.frontend_app');
    }

    public function home2()
    {
        return view('layouts.frontend_app');
    }

    public function home3()
    {
        return view('layouts.frontend_app');
    }

    // Main Sliders
    public function sliders()
    {
        $sliders = Slider::select('id', 'slider', 'url', 'sorting', 'title')->oldest('sorting')->get();
        return response()->json($sliders);
    }

    // Categories
    public function categories(Request $request)
    {
        $query = Category::select('id', 'parent_id', 'title', 'slug', 'image', 'sorting', 'status')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with('childCategories')
            ->oldest('sorting');
        if (!empty($request->keyword)){
            $query->where('title', 'LIKE', "%{$request->keyword}%");
        }
        $categories = $query->get();
        return response()->json($categories);
    }

    public function bannerCategories()
    {
        $bannerCategories = Category::select('id', 'parent_id', 'title', 'slug', 'image', 'sorting', 'status')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with('childCategories')
            ->oldest('sorting')
            ->take(4)
            ->get();
        return response()->json($bannerCategories);
    }

    // Services
    public function services()
    {
        $services = Service::latest('sorting')->get()->take(4);
        return response()->json($services);
    }

    // Campaigns
    public function campaigns()
    {
        $todayDate = date('Y-m-d');
        $res = CampaignOffer::select('id', 'title', 'last_date', 'status', 'products')
            ->where('last_date', '>=', $todayDate)
            ->where('status', 'active')
            ->oldest('sorting')->get();
        return response()->json($res);
    }

    public function bannerTodaysDeal()
    {
        $products = Product::select(Product::selectField())
            ->where('status', 'active')
            ->where('trending_product', 1)
            ->oldest('sorting')->get();
        return response()->json($products);
    }

    // Top Categories
    public function topCategories()
    {
        $categories = Category::select('id', 'parent_id', 'title', 'slug', 'image', 'sorting', 'status')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->oldest('sorting')
            ->take(8)
            ->get();;
        return response()->json($categories);
    }

    // Top Categories
    public function bannerCategoriesHome3()
    {
        $categories = Category::select('id', 'parent_id', 'title', 'slug', 'image', 'sorting', 'status')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with('childCategories')
            ->oldest('sorting')
            ->take(8)
            ->get();
        return response()->json($categories);
    }

    public function bannerCategoriesHome8()
    {
        $selectField = ['id', 'sub_category_id', 'parent_id', 'title', 'slug', 'image', 'sorting', 'status'];
        $categories = Category::select($selectField)
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->oldest('sorting')
            ->take(8)
            ->get();
        foreach ($categories as $category) {
            $category['sub_categories'] = Category::select($selectField)
                ->where('parent_id', $category['id'])
                ->where('status', 'active')
                ->oldest('sorting')
                ->get();
            foreach ($category['sub_categories'] as $subCategory) {
                $subCategory['child_categories'] = Category::select($selectField)
                    ->where('sub_category_id', $subCategory['id'])
                    ->where('status', 'active')
                    ->oldest('sorting')
                    ->get();
            }
        }
        return response()->json($categories);
    }

    // Top Brands
    public function topBrands(Request $request)
    {
        $brands = Brand::latest('sorting')->get()->take(8);
        return response()->json($brands);
    }

    // Brands
    public function brands(Request $request)
    {
        $query = Brand::latest('sorting');
        if ($request->limit != 'all') {
            $query->limit($request->limit);
        }
        $brands = $query->get();
        return response()->json($brands);
    }

    // Section One
    public function sectionOne()
    {
        $settings = StoreSetting::select('section_one_title', 'section_one_products')->first();
        if (!empty($settings)) {
            if (!empty($settings['section_one_products'])) {
                $settings['section_one_products'] = Product::select(Product::selectField())
                    ->whereIn('id', $this->getProductId($settings['section_one_products']))->take(6)->get();
            } else {
                $settings['section_one_products'] = [];
            }
        } else {
            $settings = [];
        }
        return response()->json($settings);
    }

    // Section Two
    public function sectionTwo()
    {
        $settings = StoreSetting::select('section_two_title', 'section_two_products')->first();
        if (!empty($settings)) {
            if (!empty($settings['section_two_products'])) {
                $settings['section_two_products'] = Product::select(Product::selectField())
                    ->whereIn('id', $this->getProductId($settings['section_two_products']))->take(6)->get();
            } else {
                $settings['section_two_products'] = [];
            }
        } else {
            $settings = [];
        }
        return response()->json($settings);
    }

    // Section Three
    public function sectionThree()
    {
        $settings = StoreSetting::select('section_three_title', 'section_three_products')->first();
        if (!empty($settings)) {
            if (!empty($settings['section_three_products'])) {
                $settings['section_three_products'] = Product::select(Product::selectField())
                    ->whereIn('id', $this->getProductId($settings['section_three_products']))->take(9)->get();
            } else {
                $settings['section_three_products'] = [];
            }
        } else {
            $settings = [];
        }
        return response()->json($settings);
    }

    protected function getProductId($products)
    {
        return json_decode($products, true);
    }

    public function categoryProducts()
    {
        $categoryId = StoreSetting::select('popular_section_title', 'popular_category_one', 'popular_category_two', 'popular_category_three')
            ->first();
        $categories['popular_section_title'] = $categoryId->popular_section_title;
        $categories['popular_category_one'] = Category::select('id', 'title', 'slug')->with(['products' => function ($query) {
            $query->select(Product::selectField())->take(3);
        }])->find($categoryId->popular_category_one);
        $categories['popular_category_two'] = Category::select('id', 'title', 'slug')->with(['products' => function ($query) {
            $query->select(Product::selectField())->take(3);
        }])->find($categoryId->popular_category_two);
        $categories['popular_category_three'] = Category::select('id', 'title', 'slug')->with(['products' => function ($query) {
            $query->select(Product::selectField())->take(3);
        }])->find($categoryId->popular_category_three);
        return response()->json($categories);
    }

    //  Add to Wishlist
    public function AddToWishlist(Request $request, $product_id)
    {
        $user = Auth::user();
        if (Auth::check()) {
            $exists = Wishlist::where('product_id', $product_id)->where('user_id', $user->id)->first();
            if (!$exists) {
                Wishlist::insert([
                    'product_id' => $product_id,
                    'user_id' => $user->id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['exists' => true]);
            }
        } else {
            $redirect_to = route('login');
            return response()->json(['is_login' => false, 'redirect_to' => $redirect_to]);
        }
    }

    // Global Search
    public function globalSearch(Request $request)
    {
        if ($request->keyword) {
            $query = Product::select(Product::selectField());
            $category = Category::where('title', 'like', '%' . "{$request->keyword}" . '%')->first();
            if (!empty($category)) {
                $query->where('category_id', $category->id);
            }
            $brand = Brand::where('name', 'like', '%' . "{$request->keyword}" . '%')->first();
            if (!empty($brand)) {
                $query->where('brand_id', $brand->id);
            }
            $query->where('name', 'like', '%' . "{$request->keyword}" . '%');
            $data['product'] = $query->get();
        }

        $data['keyword'] = $request->keyword;
        return response()->json($data);
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function TopSellingProducts()
    {
        $top_selling = Product::where('top_selling', '1')->latest()->take(10)->get();
        return response()->json($top_selling);
    }

    public function HotProducts()
    {
        $hot = Product::where('hot', '1')->latest()->take(8)->get();
        return response()->json($hot);
    }

}
