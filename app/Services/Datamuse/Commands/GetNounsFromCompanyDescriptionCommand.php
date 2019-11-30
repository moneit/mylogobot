<?php

namespace App\Services\Datamuse\Commands;

use App\Services\Datamuse\RequestSendCommand;

class GetNounsFromCompanyDescriptionCommand extends RequestSendCommand
{
    /**
     * GetNounFromCompanyDescriptionCommand constructor.
     *
     * @param string $description
     */
    public function __construct($description)
    {
        parent::__construct();

        $this->request->pushQueryParam('ml', $description);
    }
}