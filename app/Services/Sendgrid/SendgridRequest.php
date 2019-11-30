<?php

namespace App\Services\Sendgrid;

use GuzzleHttp\Client;

class SendgridRequest
{
    /**
     * @var string url for sendgrid
     */
    protected $url;

    /**
     * @var string request client
     */
    protected $client;

    /**
     * SendgridRequest constructor.
     *
     * @param string $route
     */
    public function __construct($route)
    {
        $this->url = 'https://api.sendgrid.com/v3'.$route;

        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer '.env('SENDGRID_API_KEY'),
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}