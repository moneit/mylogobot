<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendationTrack extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_name', 'slogan', 'details', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
//        return $this->belongsTo(User::class, 'user_id');
    }
}
