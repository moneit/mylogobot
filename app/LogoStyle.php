<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogoStyle extends Model
{
    const IconStyleName = 'icon';
    const TypographyStyleName = 'typography';
    const InitialStyleName = 'initial';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
