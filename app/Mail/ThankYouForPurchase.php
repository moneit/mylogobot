<?php

namespace App\Mail;

use App\Order;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThankYouForPurchase extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * ThankYouForPurchase constructor.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
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
                'user' => $this->order->user,
                'url' => ProductService::generateDownloadLink($this->order->logo_id, $this->order->file_id)
            ]);
    }
}
