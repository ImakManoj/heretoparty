<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ourteam extends Model
{
   protected $guarded=[];
   public function RelationDetination(){
    		return $this->belongsTo(Degination::class,'degination_id','id');
    }
}
