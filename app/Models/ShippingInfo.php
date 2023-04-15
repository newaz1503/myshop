<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class ShippingInfo extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "ShippingInfo";

    public function customer()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class,'state_id','state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
