<?php

namespace App\Listeners;

use App\Account;
use App\Events\UserRegistered;

class CreateUserAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        Account::create([
            'user_id' => $event->user->id,
            'country_id' => optional($event->country)->id,
        ]);
    }
}
