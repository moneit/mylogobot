<?php

namespace App\Mail;

use App\Order;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResendFiles extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @param $order
     *
     * @return void
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
        return $this->markdown('mails.product.resend')
            ->with([
                'user' => $this->order->user,
                'url' => ProductService::generateDownloadLink($this->order->logo_id, $this->order->file_id)
            ]);
    }
}
