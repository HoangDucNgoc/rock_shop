<?php

namespace App\Providers;

use App\Http\Curl\ExceptionHandler;
use App\Http\Curl\Facades\Facade;
use App\Http\Curl\HttpClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CurlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Facade::setHttpClient($this->app['App\Contracts\Http\Curl\HttpClient']);

        ExceptionHandler::setCircuitBreaker($this->app['Rymanalu\LaravelCircuitBreaker\CircuitBreaker']);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HttpClient::class, function ($app) {
            return new HttpClient(new Client, $app['Rymanalu\LaravelCircuitBreaker\CircuitBreaker']);
        });
        $this->app->alias(HttpClient::class, 'App\Contracts\Http\Curl\HttpClient');

    }
}
