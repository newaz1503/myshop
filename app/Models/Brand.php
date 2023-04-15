<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Str;

class Brand extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = "Brand";

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = Brand::createSlug($url->name);
        });
    }
    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = Brand::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug . $count;
        }
        return $slug;
    }

    public function getIconAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
}
