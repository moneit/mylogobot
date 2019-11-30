<?php

namespace App\Listeners;

use App\Jobs\Sendgrid\CreateUserContactInNotBuyersList;
use App\Events\UserRegistered;

class CreateSendgridContact
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
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // add to 'Not Buyers' list in sendgrid automation
        dispatch(new CreateUserContactInNotBuyersList($event->user));
    }
}
