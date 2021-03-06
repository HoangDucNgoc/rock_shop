<?php

namespace App\Http\Curl\Endpoints;

use App\Contracts\Http\Curl\Endpoint as EndpointContract;
use App\Contracts\Http\Curl\Service;
use GuzzleHttp\Psr7\Request;

abstract class Endpoint implements EndpointContract
{

    /**
     * The endpoint token
     * @var bool
     */
    protected $token;

    /**
     * status request.
     *
     * @var bool
     */
    protected $async;

    /**
     * The endpoint URI.
     *
     * @var string
     */
    protected $uri;

    /**
     * The endpoint method.
     *
     * @var string
     */
    protected $method;

    /**
     * The endpoint's options.
     *
     * @var array
     */
    protected $options;

    /**
     * The Service implementation.
     *
     * @var \App\Contracts\Http\Curl\Service
     */
    protected $service;

    /**
     * Create a new Endpoint instance.
     *
     * @param  \App\Contracts\Http\Curl\Service  $service
     * @param  array  $options
     * @return void
     */

    public function __construct(Service $service, array $options = [])
    {
        $this->service = $service;

        $this->options = $options;

    }

    /**
     * Get the status request.
     *
     * @return bool
     */
    public function getAsync()
    {
        return $this->async;
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the endpoint URI.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->normalize($this->service->uri()) . '/' . $this->normalize($this->uri ?: '');
    }

    /**
     * Get the endpoint method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method ?: 'GET';
    }

    /**
     * Get the endpoint options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the Service implementation in this endpoint.
     *
     * @return \App\Contracts\Http\Curl\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Normalize the given string.
     *
     * @param  string  $string
     * @return string
     */
    protected function normalize($string)
    {
        return trim($string, '/');
    }
}
