<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logo()
    {
        return $this->belongsTo(Logo::class);
    }

    public function currencySymbol()
    {
        return $this->hasOne(Currency::class, 'iso_code', 'currency');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
