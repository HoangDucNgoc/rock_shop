<?php

namespace App\Http\Curl\Endpoints\Item;

use App\Http\Curl\Endpoints\Endpoint;

class DeleteCategoryEndPoint extends Endpoint
{
    /**
     * The endpoint URI.
     *
     * @var string
     */

    protected $uri = '/category';
    /**
     * The endpoint method.
     *
     * @var string
     */
    protected $method = 'delete';

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
