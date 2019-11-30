<?php

namespace App\Services\Datamuse;


class RequestSendCommand
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * RequestSendCommand constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->request->send();
    }
}