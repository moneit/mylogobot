<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palette extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'palettes';

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
        'bg_color', 'company_name_color', 'slogan_color', 'symbol_color'
    ];

    /**
     * Define a many-to-many relationship between color category and palette.
     */
    public function colorCategory()
    {
        return $this->belongsToMany(ColorCategory::class);
    }

    public function tones()
    {
        return $this->belongsToMany(Color::class);
    }
}
