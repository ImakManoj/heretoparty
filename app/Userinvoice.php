<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userinvoice extends Model
{
    protected $guarded=[];

     public function getUserInvoice(){
		return $this->belongsToMany(User::class,'user_id');
    }
}
