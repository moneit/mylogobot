<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeDownload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'logo_id'];
}
