<?php

namespace App\Services\Sendgrid\Commands\Lists;

use App\Services\Sendgrid\RequestSendCommand;
use App\Services\Sendgrid\Requests\PostRequest;

class CreateListCommand extends RequestSendCommand
{
    /**
     * CreateListCommand constructor.
     */
    public function __construct()
    {
        parent::__construct(new PostRequest('/marketing/lists'));
    }
}