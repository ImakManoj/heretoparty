<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Transaction extends Eloquent
{
    use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'opponent_id', 'payment_type', 'quantity', 'price', 'total_amount', 'transaction_id', 'created_at'
    ];

    public function getOpponentUser()
    {
        return $this->belongsTo('App\Users', 'opponent_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'cat_id');
    }
}
