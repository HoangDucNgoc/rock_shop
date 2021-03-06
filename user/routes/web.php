<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

/*
 *  middleware set just proxy and check json data request
 */
$router->group(['middleware' => ['proxy', 'json', 'token']], function () use ($router) {

    $router->post('/user/register', 'UserController@register');
    $router->get('/user/login', 'UserController@login');
    $router->get('/user/check_token', 'UserController@checkToken');
    // $router->post('/user/register',['middleware' => 'auth'], 'UserController@register');

});
