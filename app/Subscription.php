<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

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
    protected $fillable = ['user_id', 'transaction_id', 'status', 'is_expire', 'expire_date'];

    public function getUserInfo()
    {
        return $this->belongsTo('App\User', 'user_id')->where('device_token', '<>', '');
    }

    
}
