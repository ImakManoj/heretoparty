<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plans';

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
    protected $fillable = ['id', 'name', 'description', 'price', 'period', 'status'];

    public function getSongInfo()
    {
        return $this->belongsTo('App\Song', 'song_id');
    }

    
}
