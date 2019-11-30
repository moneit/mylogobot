<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorPalette extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'color_palette';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
