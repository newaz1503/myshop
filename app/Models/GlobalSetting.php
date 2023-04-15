<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class GlobalSetting extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "GlobalSetting";

    public function getFooterSectionOneLinksAttribute($value)
    {
        if (!empty($value)){
            $footerLinks = json_decode($value,true);
        }else{
            $footerLinks = [[]];
        }
        return $footerLinks;
    }
    public function getFooterSectionTwoLinksAttribute($value)
    {
        if (!empty($value)){
            $footerLinks = json_decode($value,true);
        }else{
            $footerLinks = [[]];
        }
        return $footerLinks;
    }
    public function getSiteMetaKeywordsAttribute($value)
    {
        return $value ? explode(',',$value) : [];
    }

    public function getLogoAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
    public function getFaviconAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
    public function getLoaderAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
    public function getWhiteLogoAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
    public function getGetwayImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
}
