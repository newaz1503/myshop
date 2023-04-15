<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class OrderDetails extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "OrderDetails";
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
