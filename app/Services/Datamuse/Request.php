<?php

namespace App\Services\Datamuse;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;

class Request
{
    /**
     * @var string base url for datamuse
     */
    private $baseUrl;

    /**
     * @var array query parameters
     */
    private $queryParams;

    /**
     * @var request client
     */
    private $client;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->baseUrl = 'https://api.datamuse.com/words';
        $this->queryParams = [];
        $this->client = new Client();
    }

    /**
     * @return mixed
     */
    public function send()
    {
        $url = $this->buildUrl();

        $response = $this->client->get($url);
        $content = $response->getBody()->getContents();

        return [
            'status' => $response->getStatusCode(),
            'payload' => json_decode($content),
        ];
    }

    /**
     * @return string
     */
    private function buildUrl()
    {
        $url = $this->baseUrl;

        foreach($this->queryParams as $index => $queryParam) {

            $key = $queryParam['key'];
            $value = str_replace(' ', '+', $queryParam['value']);

            if ($index === 0) {
                $url .= '?';
            } else {
                $url .= '&';
            }

            $url .= "$key=$value";
        }

        return $url;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function pushQueryParam($key, $value)
    {
        array_push($this->queryParams, [
            'key' => $key,
            'value' => $value,
        ]);
    }
}