<?php

namespace App\Http\Curl\Endpoints\User;

use App\Http\Curl\Endpoints\Endpoint;

class RegisterEndpoint extends Endpoint
{
    /**
     * The endpoint URI.
     *
     * @var string
     */
    //protected $uri = 'user/profile/token';

    protected $uri = '/user/register';
    /**
     * The endpoint method.
     *
     * @var string
     */
    protected $method = 'POST';

    /**
     * status request.
     * wait response  : true 
     * async          : false
     * @var bool
     */
    protected $async = false;
}
