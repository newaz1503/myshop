<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;
use App\Models\Website\News;
use Illuminate\Support\Str;

class Category extends BaseModel
{
    protected $guarded = ['id'];
    protected $appends = ['productCount'];

    protected static $logName = "Category";


    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = Category::createSlug($url->title);
        });
    }
    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = Category::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug . $count;
        }
        return $slug;
    }

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }
    public function getProductCountAttribute($value)
    {
        $categoryId = $this->attributes['id'];
        return Product::where('category_id', $categoryId)->count();
    }


    public function child()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id');
    }
    public function subCategories()
    {
        return $this->belongsTo(Category::class,'sub_category_id','id');
    }

    public function childCategories()
    {
        return $this->child()->with('childCategories')->oldest('sorting')->select(
            'id','parent_id','title','slug','image','sorting','status'
        );
    }

    public function products()
    {
      return $this->hasMany(Product::class,'category_id','id');
    }
}
