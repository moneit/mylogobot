<?php

namespace App\Services\Sendgrid;

interface Request
{
    /**
     * @return mixed
     */
    public function send();
}