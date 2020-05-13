<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Notification extends Eloquent
{
    // use AuthenticableTrait;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected $fillable = [
    //     'sender_id', 'receiver_id', 'title', 'message', 'status', 'created_at'
    // ];

    // public function getSenderInfo()
    // {
    //     return $this->belongsTo('App\Users', 'sender_id');
    // }

    // public function getVerb()
    // {
    //     return $this->belongsTo('App\Verbs', 'verb_id');
    // }
}
