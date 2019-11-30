<?php

namespace App\Listeners;

use App\Jobs\Product\GenerateProductForOrder;
use App\Jobs\Mail\SendThankYouMail;
use App\Events\ProductPurchased;

class GenerateFirstProduct
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
     * @param  \App\Events\ProductPurchased  $event
     * @return void
     */
    public function handle(ProductPurchased $event)
    {
        GenerateProductForOrder::withChain([
            new SendThankYouMail($event->order),
        ])->dispatch($event->order);
    }
}
