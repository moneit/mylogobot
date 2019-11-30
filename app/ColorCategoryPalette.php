<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorCategoryPalette extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'color_category_palette';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
