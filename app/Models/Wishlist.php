<?php

/**
 * izi-starter
 * Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Product;
use App\Models\Base\BaseModel;

class Wishlist extends BaseModel
{
    protected $guarded = [];

    protected static $logName = "Wishlist";
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
