<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'subject', 'message'];
}
