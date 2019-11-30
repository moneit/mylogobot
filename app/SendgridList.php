<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendgridList extends Model
{
    const NotBuyersListName = 'Not Buyers';
    const BuyersListName = 'Buyers'; // these constants should be synced with sendgrid list names, unless system is broken

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Scope a query to only include 'Not Buyers' list.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotBuyers($query)
    {
        return $query->where('name', '=', self::NotBuyersListName);
    }

    /**
     * Scope a query to only include 'Buyers' list.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuyers($query)
    {
        return $query->where('name', '=', self::BuyersListName);
    }
}
