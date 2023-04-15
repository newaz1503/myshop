<?php

/**
 * Tushar Ahmed izi cms
 */

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Exception;
use App\Models\CampaignOffer;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use App\Http\Controllers\Controller;

class CampaignOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query  = CampaignOffer::with('product')->latest();
        $query->whereLike( $request->field_name, $request->value );

        $datas  = $query->paginate($request->pagination);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                $data = $request->only('title','last_date','status','sorting');
                foreach ($request->products as $products) {
                    $data['products'][] = $products['id'];
                }
                if (!empty($data['products'])){
                    $data['products']  = json_encode($data['products']);
                }
                $res = CampaignOffer::create($data);
                return $this->responseReturn( "create", $res );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignOffer  $campaignOffer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CampaignOffer $campaignOffer)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
//        $campaignOffer['products'] = Product::select('id', 'name', 'featured_image','sale_price')
//            ->whereIn('id',json_decode($campaignOffer['products'],true))->get();
        return $campaignOffer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaignOffer  $campaignOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignOffer $campaignOffer)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampaignOffer  $campaignOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaignOffer $campaignOffer)
    {
        if ($this->validateCheck($request, $campaignOffer->id)) {
            try {
                $data = $request->only('title','last_date','status','sorting');
                foreach ($request->products as $products) {
                    $data['products'][] = $products['id'];
                }
                if (!empty($data['products'])){
                    $data['products']  = json_encode($data['products']);
                }
                $campaignOffer->fill( $data )->save();
                return $this->responseReturn( "update", $campaignOffer );
            } catch (Exception $ex) {
                return response()->json( ['exception' => $ex->errorInfo ?? $ex->getMessage()], 422 );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignOffer  $campaignOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignOffer $campaignOffer)
    {
        $res = $campaignOffer->delete();
        return $this->responseReturn( "delete", $res );
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id=null)
    {
        return true;
        return $request->validate([
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ],[
            //ex: 'name' => "This name is required" (custom message)
        ]);
    }
}
