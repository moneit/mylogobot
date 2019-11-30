<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'containers';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name'
    ];
}
