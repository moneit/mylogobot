<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FontRecommendationsTypographyLogo extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function companyNameFont()
    {
        return $this->belongsTo(Font::class, 'company_name_font_id', 'id');
    }

    public function sloganFont()
    {
        return $this->belongsTo(Font::class, 'slogan_font_id', 'id');
    }
}
