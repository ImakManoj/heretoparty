<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'playlists';

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
    protected $fillable = ['user_id', 'playlist_id', 'song_id'];

    public function getPlaylistInfo()
    {
        return $this->belongsTo('App\UserPlaylist', 'playlist_id');
    }

    public function getSongInfo()
    {
        return $this->belongsTo('App\Song', 'song_id');
    }
}
