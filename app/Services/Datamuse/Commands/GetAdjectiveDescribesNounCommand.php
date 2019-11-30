<?php

namespace App\Services\Datamuse\Commands;

use App\Services\Datamuse\RequestSendCommand;

class GetAdjectiveDescribesNounCommand extends RequestSendCommand
{
    /**
     * GetAdjectiveDescribesNounCommand constructor.
     *
     * @param string $noun
     */
    public function __construct($noun)
    {
        parent::__construct();

        $this->request->pushQueryParam('rel_jjb', $noun);
    }
}