<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class City extends BaseModel
{
    protected $guarded = ['id'];
    
    protected static $logName = "City";
}
