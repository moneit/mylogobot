<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * System roles
     *
     * @var array
     */
    public static $system = [
        'ADMIN' => 'admin',
        'DEVELOPER' => 'developer',
        'SUPER_ADMIN' => 'super_admin',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
