<?php

namespace App\Services\Cortical\Requests;

use App\Services\Cortical\Request;
use App\Services\Cortical\CorticalRequest;
use GuzzleHttp\Exception\GuzzleException;

class PostRequest extends CorticalRequest implements Request
{
    /**
     * @var string request body
     */
    private $requestBody;

    /**
     * PostRequest constructor.
     *
     * @param string $route
     * @param string $requestBody
     */
    public function __construct($route = '', $requestBody = '')
    {
        parent::__construct($route);

        $this->requestBody = $requestBody;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        try {
            $response = $this->client->request('POST', $this->url, [
                'body' => $this->requestBody
            ]);
        } catch (GuzzleException $e) {
            return [
                'status' => 408,
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ];
        }
        $content = $response->getBody()->getContents();

        if ($content) {
            return [
                'status' => $response->getStatusCode(),
                'payload' => json_decode($content),
            ];
        } else {
            return [
                'status' => $response->getStatusCode(),
                'payload' => [],
            ];
        }
    }
}