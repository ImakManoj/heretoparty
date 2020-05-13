<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlaylist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_playlists';

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
    protected $fillable = ['user_id', 'name', 'description'];

    
}
