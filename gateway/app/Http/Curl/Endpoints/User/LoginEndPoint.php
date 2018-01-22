<?php

namespace App\Http\Curl\Endpoints\User;

use App\Http\Curl\Endpoints\Endpoint;

class LoginEndpoint extends Endpoint
{
    /**
     * The endpoint URI.
     *
     * @var string
     */
    //protected $uri = 'user/profile/token';

    protected $uri = '/user/login';
    /**
     * The endpoint method.
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * status request.
     * wait response  : true
     * async          : false
     * @var bool
     */
    protected $async = false;

    /**
     * The endpoint token
     * @var bool
     */
    protected $token = false;
}
