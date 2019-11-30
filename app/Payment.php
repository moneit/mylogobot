<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency', 'amount'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
