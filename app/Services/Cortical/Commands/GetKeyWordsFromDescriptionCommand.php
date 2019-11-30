<?php

namespace App\Services\Cortical\Commands;

use App\Services\Cortical\RequestSendCommand;
use App\Services\Cortical\Requests\PostRequest;

class GetKeyWordsFromDescriptionCommand extends RequestSendCommand
{
    /**
     * GetKeyWordsFromDescriptionCommand constructor.
     *
     * @param string $description
     */
    public function __construct($description)
    {
        parent::__construct(new PostRequest('/text/keywords?retina_name=en_associative', $description));
    }
}