<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Faq extends BaseModel
{
    protected $table = 'faqs';
    protected $guarded = ['id'];

    protected static $logName = "Faq";
}
