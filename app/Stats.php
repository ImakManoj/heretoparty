<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stats';

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
    protected $fillable = ['type', 'user_id', 'song_id', 'play_count'];

    public function getSongInfo()
    {
        return $this->belongsTo('App\Song', 'song_id');
    }

    
}
