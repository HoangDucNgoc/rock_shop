<?php

namespace App\Providers;

use App\Http\Curl\Facades\User as UserMicroservice;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Check user login
        // call service user/check_token to check token

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('token')) {
                $appToken = Carbon::today()->toDateTimeString() . '_' . env('PRIVATE_REQUEST_KEY', 'TOKEN_INVALID');
                $result   = UserMicroservice::checkToken(['headers' => [
                    'token'     => $request->header('token'),
                    'APP_TOKEN' => encrypt($appToken),
                ]]);
                if ($result->getStatusCode() == 200) {
                    return $result->getBody()->data;
                }

            }
        });
    }
}
