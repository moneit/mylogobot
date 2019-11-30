<?php

namespace App\Services\Cortical;

class RequestSendCommand
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * RequestSendCommand constructor.
     */
    /**
     * RequestSendCommand constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->request->send();
    }
}