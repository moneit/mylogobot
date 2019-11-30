<?php

namespace App\Services\Cortical;

use GuzzleHttp\Client;

class CorticalRequest
{
    /**
     * @var string url for Cortical
     */
    protected $url;

    /**
     * @var string request client
     */
    protected $client;

    /**
     * CorticalRequest constructor.
     *
     * @param string $route
     */
    public function __construct($route)
    {
        $this->url = 'http://api.cortical.io/rest'.$route;

        $this->client = new Client([
            'headers' => [
                'api-key' => env('CORTICAL_API_KEY'),
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}