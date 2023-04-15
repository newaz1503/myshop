<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static $logName = 'User';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        if ($this->attributes['provider_id'] == ''){
            if (!empty($value)) {
                return url('/') . "/public/storage/" . $value;
            }
        }else{
            return $value;
        }
        return null;
    }

    public function shippingInfo()
    {
        return $this->belongsTo(ShippingInfo::class,'id','user_id');
    }
    public function review(){
        return $this->hasMany(ProductReview::class);
    }
}
