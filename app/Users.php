<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Users extends Eloquent
{
    protected $collection = 'users';
    
    protected $fillable = [
        'carcompany', 'model','price'
    ];
}