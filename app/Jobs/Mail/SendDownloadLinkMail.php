<?php

namespace App\Jobs\Mail;

use App\Order;
use App\User;
use App\Mail\DownloadLink;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDownloadLinkMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param $orderId
     * @param $user
     *
     * @return void
     */
    public function __construct($orderId, $user = null)
    {
        $this->order = Order::findOrFail($orderId);
        $this->user = $user ?? User::findOrFail($this->order->user_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->user)->send(new DownloadLink($this->order, $this->user));
    }
}
