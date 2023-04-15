<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\OrderDetails;
use App\Models\Base\BaseModel;

class Order extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "Order";

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function shippingInfo()
    {
        return $this->belongsTo(ShippingInfo::class);
    }
}
