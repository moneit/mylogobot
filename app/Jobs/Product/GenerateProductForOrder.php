<?php

namespace App\Jobs\Product;

use App\Order;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class GenerateProductForOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * GenerateProductForOrder constructor.
     *
     * @param $order
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->productService = new ProductService();
    }

    /**
     * @return string
     */
    public function handle()
    {
        if (empty($this->order->file_id)) {
            $fileId = $this->productService->generate($this->order->package->name, $this->order->logo);

            if (! is_null($fileId)) {
                $this->order->file_id = $fileId;
                $this->order->save();
            }
        }

        return $this->order;
    }
}
