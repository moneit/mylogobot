<?php

namespace App\Services\Cortical;

interface Request
{
    /**
     * @return mixed
     */
    public function send();
}