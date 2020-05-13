<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favourites';

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
    protected $fillable = ['type', 'user_id', 'fav_id', 'status'];


    public function getContentsInfo()
    {
        return $this->belongsTo('App\Content', 'fav_id');
    }

    public function getSongInfo()
    {
        return $this->belongsTo('App\Song', 'fav_id');
    }

    
}
