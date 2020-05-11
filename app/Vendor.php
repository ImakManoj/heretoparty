<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded=[];

    public function getCategoryList(){
   		return $this->hasMany(Vendorcategorylist::class,'vendor_id');
   }

   			public function vendorCategory(){
   				return $this->belongsTo(categoryModel::class,'id');
   			}

   	 public function userWiths(){
   		return $this->belongsTo(User::class,'user_id');
   }

}
