<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded=[]; 

    		public function vendorService(){
   				return $this->hasMany(Vendor::class,'id');
   			}

   			public function serviceGallery(){
   				return $this->hasMany(Serviceimage::class,'srvice_id');
   			 }
}
