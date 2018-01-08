<?php

namespace App\Http\Curl\Endpoints\User;

use App\Http\Curl\Endpoints\Endpoint;

class CheckTokenEndpoint extends Endpoint
{
    /**
     * The endpoint URI.
     *
     * @var string
     */
    //protected $uri = 'user/profile/token';

    protected $uri = '/posts/42';
    /**
     * The endpoint method.
     *
     * @var string
     */
    protected $method = 'GET';
}
