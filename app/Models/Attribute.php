<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Attribute extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "Attribute";


    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
