<?php

namespace App\Services\Sendgrid\Commands\Contacts;

use App\Services\Sendgrid\RequestSendCommand;
use App\Services\Sendgrid\Requests\PutRequest;

class AddUpdateContactsCommand extends RequestSendCommand
{
    /**
     * AddUpdateContactsCommand constructor.
     *
     * @param array $listIds
     * @param array $contacts
     */
    public function __construct($listIds, $contacts)
    {
        parent::__construct(
            new PutRequest('/marketing/contacts', [
                'list_ids' => $listIds,
                'contacts' => $contacts
            ])
        );
    }
}