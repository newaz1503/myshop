<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class EmailSetting extends BaseModel
{
    protected $table = "email_settings";
    protected $guarded = ['id'];

    protected static $logName = "EmailSetting";
}
