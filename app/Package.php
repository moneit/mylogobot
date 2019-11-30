<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'price'];

    const basicPackageName = 'basic';
    const basicPackagePrice = 0;

    const premiumPackageName = 'premium';
    const premiumPackagePrice = 19;

    const enterprisePackageName = 'enterprise';
    const enterprisePackagePrice = 49;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
