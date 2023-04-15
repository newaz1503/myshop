<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class AttributeValue extends BaseModel
{
    protected $guarded = ['id'];
    
    protected static $logName = "AttributeValue";
}
