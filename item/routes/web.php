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

$router->group(['middleware' => ['json', 'token']], function () use ($router) {
    $router->get('/categories', 'CategoryController@listCategory');
    $router->post('/category', 'CategoryController@createCategory');
    $router->put('/category', 'CategoryController@updateCategory');
    $router->delete('/category', 'CategoryController@deleteCategory');
});
