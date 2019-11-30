<?php

namespace App\Services\Support;

use App\Jobs\Mail\SendSupportMail as SendMailToSupport;

class Service
{
    public function sendMail($name, $from, $subject, $message)
    {
        dispatch(new SendMailToSupport($name, $from, $subject, $message));
    }
}