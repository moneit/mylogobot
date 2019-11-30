<?php

namespace App\Services\Sendgrid\Requests;

use App\Services\Sendgrid\Request;
use App\Services\Sendgrid\SendgridRequest;
use GuzzleHttp\Exception\GuzzleException;

class GetRequest extends SendgridRequest implements Request
{
    /**
     * @var array
     */
    private $queryParams;

    /**
     * GetRequest constructor.
     *
     * @param string $route
     * @param array $queryParams
     */
    public function __construct($route = '', $queryParams = [])
    {
        parent::__construct($route);

        $this->queryParams = $queryParams;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        try {
            $response = $this->client->request('GET', $this->url, [
                'query' => $this->queryParams
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