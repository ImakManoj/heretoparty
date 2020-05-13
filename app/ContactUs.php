<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ContactUs extends Eloquent
{
    protected $table = 'contactus';
    
    protected $fillable = [
        'user_id', 'title','message'
    ];
}