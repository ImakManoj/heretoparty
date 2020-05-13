<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

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

    protected $fillable = [
        'user_id', 'transaction_id', 'amount', 'status', 'created_at'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

}
