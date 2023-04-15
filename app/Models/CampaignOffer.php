<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Carbon;

class CampaignOffer extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "CampaignOffer";

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductsAttribute($value)
    {
        $productId = $value ? json_decode($value,true) : $value;
        return Product::select(Product::selectField())
            ->whereIn('id',$productId)->get();
    }

//    public function getLastDateAttribute($value)
//    {
////        return Carbon::parse($this->attributes['last_date'])
////            ->format('F m y');
////       return $this->attributes['last_date'] = date('F m y', strtotime($value));
//    }
}
