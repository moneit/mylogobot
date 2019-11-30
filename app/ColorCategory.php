<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'color_categories';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Define a many-to-many relationship between color category and palette.
     */
    public function palettes()
    {
        return $this->belongsToMany(Palette::class);
    }
}
