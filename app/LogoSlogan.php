<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogoSlogan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logo_slogans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_id', 'font_id', 'text', 'font_size', 'letter_space', 'line_space', 'color_hex', 'color_opacity', 'capitalization',
    ];
}
