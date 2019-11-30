<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSendgridContact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sendgrid_contact_id'];

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
