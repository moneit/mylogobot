<?php

namespace App\Services\Sendgrid\Requests;

use App\Services\Sendgrid\Request;
use App\Services\Sendgrid\SendgridRequest;
use GuzzleHttp\Exception\GuzzleException;

class PostRequest extends SendgridRequest implements Request
{
    /**
     * @var array post json body
     */
    private $body;

    /**
     * PostRequest constructor.
     *
     * @param string $route
     * @param array $body
     */
    public function __construct($route = '', $body = [])
    {
        parent::__construct($route);

        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        try {
            $response = $this->client->request('POST', $this->url, [
                'body' => json_encode($this->body)
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

        return [
            'status' => $response->getStatusCode(),
            'payload' => json_decode($content),
        ];
    }
}