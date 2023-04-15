<?php

/**
 * izi-starter
* Developed: Tushar ahmed
 */

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Str;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class Product extends BaseModel
{
    protected $appends = ['dicounted_price'];
    protected $casts = [
        'purchase_price'    => 'double',
        'sale_price'        => 'double',
        'discount_amount'   => 'double',
        'tax_amount'        => 'double',
        'vat_amount'        => 'double',
    ];

    public static function selectField()
    {
        return [
            'id',
            'name',
            'slug',
            'sale_price',
            'featured_image',
            'discount_type',
            'discount_amount',
            'vat_amount',
            'tax_amount',
            'rating',
        ];
    }
    protected $guarded = ['id'];

    protected static $logName = "Product";


    public function getRouteKeyName()
    {
        return 'slug';
    }

//    public function getSalePriceAttribute($value)
//    {
//        return number_format($value,2);
//    }
//    public function getParchasePriceAttribute($value)
//    {
//        return number_format($value,2);
//    }

    public function getDicountedPriceAttribute()
    {
        $price =  0;
        $sale_price  = $this->attributes['sale_price'];
        if(!empty($this->attributes['discount_type'])){
           if ($this->attributes['discount_type'] == 'percent'){
               $price = ($sale_price - $sale_price * $this->attributes['discount_amount'] / 100);
           } else{
               $price = ($sale_price - $this->attributes['discount_amount']);
           }
        }
        return $price;
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = Product::createSlug($url->name);
        });
    }
    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = Product::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug . $count;
        }
        return $slug;
    }

    public function getFeaturedImageAttribute($value)
    {
        if (!empty($value)) {
            return url('/') . "/public/storage/" . $value;
        }
        return null;
    }

    public function getProductGalleryAttribute($value)
    {
        if (!empty($value)){
            $images = json_decode($value,true);
            $image_gallery = [];
            foreach ($images as $image) {
                if (!empty($image)) {
                    $image_gallery[] = url('/') . "/public/storage/" . $image;
                }
            }
            return $image_gallery;
        }
        return null;
    }
    public function getSpecificationsAttribute($value)
    {
        if (!empty($value)){
            $specifications = json_decode($value,true);
        }else{
            $specifications = [[]];
        }
        return $specifications;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public static function decrementQty($productId, $qty)
    {
        $product = Product::findOrFail($productId);
        $product->quantity = $product->quantity - $qty;
        $product->save();
        return true;
    }

    public function variantProduct()
    {
        return $this->hasMany(VariantProduct::class);
    }
}
