<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DatalistController extends Controller
{

    public function productList()
    {
        $products = Product::select('id', 'name', 'featured_image','sale_price')->where('status', 'active')->latest()->get();
        return response()->json($products);
    }

//    public function saleProducts(Request $request)
//    {
//        $query = Product::where('status', 'active')->latest();
//        if (!empty($request)) {
//            $query->whereLike( $request->field_name, $request->value );
//        }
//        $products = $query->paginate($request->pagination);
//        return new Resource($products);
//    }

    public function countries()
    {
        $countries  = Country::all();
        return response()->json($countries);
    }

    public function customers()
    {
        $customers = User::all();
        return response()->json($customers);
    }

    public function states(Request $request)
    {
        $states = State::where('country_id',$request->country_id)->get();
        return response()->json($states);
    }
    public function cities(Request $request)
    {
        $query = City::where('country_id',$request->country_id);
        if ($request->state_id){
            $query->where('state_id',$request->state_id);
        }
        $states = $query->get();
        return response()->json($states);
    }


    public function vendorList()
    {
        $vendors =  Vendor::select('id','name')->get();
        return response()->json($vendors);
    }

    public function attributes()
    {
        $attribute =  Attribute::select('id','name')->get();
        return response()->json($attribute);
    }
    public function attributeValues($attId)
    {
        $attributeValues =  AttributeValue::select('id','value','attribute_id')->where('attribute_id',$attId)->get();
        return response()->json($attributeValues);
    }

    public function storeCountry()
    {
        $fileName = public_path('countries.json');
        $file  = file_get_contents($fileName);
        $countries = json_decode($file);
        dd($countries);
        foreach ($countries as $country) {
            $data = [
                'country_id' => $country->id,
                'name' => $country->name,
                'code' => $country->iso3,
                'phone_code' => $country->phone_code,
                'capital' => $country->capital,
                'currency' => $country->currency,
                'currency_name' => $country->currency_name,
                'currency_symbol' => $country->currency_symbol,
                'native' => $country->native,
                'region' => $country->region,
                'numeric_code' => $country->numeric_code,
            ];
            Country::create($data);
        }

    }

}
