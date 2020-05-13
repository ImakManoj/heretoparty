<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cat_id', 'name', 'description', 'image', 'status', 'is_delete'];


    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'cat_id');
    }

    
}
o