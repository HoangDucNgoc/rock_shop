<?php

namespace App\Http\Curl\Services;

use App\Contracts\Http\Curl\Service;

class ItemService implements Service
{
    /**
     * Get the microservice's base URI.
     *
     * @return string
     */
    public function uri()
    {
        return env('MICROSERVICE_ITEM_URI');
    }

    /**
     * Get the microservice's name.
     *
     * @return string
     */
    public function name()
    {
        return 'Item Microservice';
    }
}
