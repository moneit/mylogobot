<?php

namespace App\Services\Sendgrid\Requests;

use App\Services\Sendgrid\Request;
use App\Services\Sendgrid\SendgridRequest;
use GuzzleHttp\Exception\GuzzleException;

class PutRequest extends SendgridRequest implements Request
{
    /**
     * @var array put parameters
     */
    private $jsonParams;

    /**
     * PutRequest constructor.
     *
     * @param string $route
     * @param array $jsonParams
     */
    public function __construct($route = '', $jsonParams = [])
    {
        parent::__construct($route);

        $this->jsonParams = $jsonParams;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        try {
            $response = $this->client->request('PUT', $this->url, [
                'json' => $this->jsonParams
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