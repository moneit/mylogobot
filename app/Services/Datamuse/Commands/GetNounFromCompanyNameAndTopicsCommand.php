<?php

namespace App\Services\Datamuse\Commands;

use App\Services\Datamuse\RequestSendCommand;

class GetNounFromCompanyNameAndTopicsCommand extends RequestSendCommand
{
    /**
     * GetNounFromCompanyDescriptionCommand constructor.
     *
     * @param string $name
     * @param array $topics
     */
    public function __construct($name, $topics = [])
    {
        parent::__construct();

        $this->request->pushQueryParam('ml', $name);
        $this->request->pushQueryParam('topics', implode(' ', $topics));
    }
}