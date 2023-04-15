<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Sale extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "Sale";

    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function shippingInfo()
    {
        return $this->belongsTo(ShippingInfo::class);
    }

}
