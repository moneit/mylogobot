<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogoIcon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logo_icons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tags', 'min_x', 'min_y', 'max_x', 'max_y', 'clip_rule', 'fill_rule', 'size', 'line_space', 'color_hex', 'color_opacity', 'logo_id', 'hidden'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];
}