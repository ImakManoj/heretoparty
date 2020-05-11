<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthModel extends Authenticatable
{
	 use Notifiable; 

    //
     protected $table="users";
	 protected $fillable = [
        'first_name','last_name', 'email', 'password','role','country_id','city_id','images','mobile',
    ];

     protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

