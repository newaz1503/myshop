<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\User;
use App\Models\Base\BaseModel;

class ProductReview extends BaseModel
{
    protected $guarded = [];

    protected static $logName = "ProductReview";
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
