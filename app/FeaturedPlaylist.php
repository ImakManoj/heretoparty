<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedPlaylist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'featured_playlists';

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
    protected $fillable = ['content_id', 'status'];


    public function getPlaylistInfo()
    {
        return $this->belongsTo('App\Content', 'content_id');
    }

    
}
