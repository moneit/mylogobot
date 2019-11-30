<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logos';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function name()
    {
        return $this->hasOne(LogoName::class);
    }

    public function slogan()
    {
        return $this->hasOne(LogoSlogan::class);
    }

    public function initials()
    {
        return $this->hasOne(LogoInitial::class);
    }

    public function icon()
    {
        return $this->hasOne(LogoIcon::class);
    }

    public function container()
    {
        return $this->hasOne(LogoContainer::class);
    }

    public function freeDownloads()
    {
        return $this->hasMany(FreeDownload::class);
    }
}
