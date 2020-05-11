<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cityModel extends Model
{
    protected $table="cities";
    protected $guarded=[]; 


    public function RelationCountry(){
    		return $this->belongsTo(countryModel::class,'country_id','id');
    }
}
