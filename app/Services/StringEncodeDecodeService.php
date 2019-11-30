<?php

namespace App\Services;


class StringEncodeDecodeService
{
    public static function encode(String $str)
    {
        return base64_encode($str);
    }

    public static function decode(String $str)
    {
        return base64_decode($str);
    }
}