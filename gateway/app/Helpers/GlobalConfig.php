<?php

namespace App\Helpers;

class GlobalConfig
{
    private $token;

   

    public static function getToken()
    {
        return $this->token;
    }

    public static function setToken($apiToken)
    {
        $this->token = $apiToken;
    }
}
