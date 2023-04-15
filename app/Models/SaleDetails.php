<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class SaleDetails extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "SaleDetails";

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
