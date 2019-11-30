<?php

namespace App;

use App\Mail\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, MustVerifyEmailTrait, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'temp_pwd' , 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        \Mail::to($this)->send(new VerifyEmail($this));
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function logos()
    {
        return $this->hasMany(Logo::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sendgridContact()
    {
        return $this->hasOne(UserSendgridContact::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function freeDownloads()
    {
        return $this->hasMany(FreeDownload::class);
    }

    public function isAdmin()
    {
        $adminRoles = $this->roles()->select(['name'])->get()->filter( function($item){
            return in_array($item->name, [Role::$system['ADMIN'], Role::$system['SUPER_ADMIN']]);
        });

        return $adminRoles->count() > 0;
    }
}
