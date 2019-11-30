<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogoContainer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logo_containers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_id', 'container_id', 'size', 'color_hex', 'color_opacity',
    ];

    public function logo()
    {
        return $this->belongsTo(Logo::class);
    }
}