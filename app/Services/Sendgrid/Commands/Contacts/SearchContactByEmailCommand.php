<?php

namespace App\Services\Sendgrid\Commands\Contacts;

use App\Services\Sendgrid\RequestSendCommand;
use App\Services\Sendgrid\Requests\PostRequest;

class SearchContactByEmailCommand extends RequestSendCommand
{
    /**
     * SearchContactByEmailCommand constructor.
     *
     * @param string $email
     */
    public function __construct($email)
    {
        parent::__construct(
            new PostRequest('/marketing/contacts/search',
                [
//                    'contacts' => 'primary_email LIKE "' . $email . '%" AND CONTAINS(list_ids, "9ab27737-f5bf-4370-b5f7-3624b89ccde2")' // sample
                    'contacts' => 'primary_email LIKE "' . $email . '%"'
                ]
            )
        );
    }
}