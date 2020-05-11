<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userquote extends Model
{
    protected $guarded=[];

      public function getInvoice(){
		return $this->belongsTo(Userinvoice::class,'userinvoice_id');
    }
    public function GetUsers(){
    	return $this->belongsTo(User::class,'user_id');
    }

    public function getvendors(){
    	return $this->belongsTo(Vendor::class,'vendor_id');
    }

}
