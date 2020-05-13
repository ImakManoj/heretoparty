<?php

namespace App;

// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'gender', 'dob', 'profile', 'social_id', 'social_type', 'device_type', 'device_token', 'is_notification', 'pass_token', 'stripe_customer_id'   // ,'status', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getKeywords()
    {
        return $this->belongsTo('App\keyword', 'user_id');
    }
}
