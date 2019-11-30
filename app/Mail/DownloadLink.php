<?php

namespace App\Mail;

use App\Order;
use App\User;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var User
     */
    private $user;

    /**
     * ThankYouForPurchase constructor.
     *
     * @param $order
     * @param null $user
     */
    public function __construct($order, $user = null)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.product.thankyou')
            ->with([
                'user' => $this->user ?? $this->order->user,
                'url' => ProductService::generateDownloadLink($this->order->logo_id, $this->order->file_id)
            ]);
    }
}
