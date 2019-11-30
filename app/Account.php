<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'country_id', 'vat', 'state', 'city', 'address', 'postal_code'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
