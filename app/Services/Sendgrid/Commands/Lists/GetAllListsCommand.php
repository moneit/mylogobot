<?php

namespace App\Services\Sendgrid\Commands\Lists;

use App\Services\Sendgrid\RequestSendCommand;
use App\Services\Sendgrid\Requests\GetRequest;

class GetAllListsCommand extends RequestSendCommand
{
    /**
     * GetAllListsCommand constructor.
     */
    public function __construct()
    {
        parent::__construct(new GetRequest('/marketing/lists'));
    }
}