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
$router->group(['middleware' => 'throttle'], function () use ($router) {

    $router->post('/user/register', 'UserController@register');
    $router->get('/user/login', 'UserController@login');

    /*
    * check login
    */
    $router->group(['middleware' => 'auth'], function () use ($router) {
        
        $router->get('/user/profile', 'UserController@profile');

        /*
		|--------------------------------------------------------------------------
		| Check role of user
		|--------------------------------------------------------------------------
		|
		| Url  : /admin/name_feature
		| Ex   : /admin/category 
		| name_fature is name role and controller name and must same with value of field name in the table fature
		|
		 */
        $router->group(['prefix' => 'admin','middleware' => 'role'], function () use ($router) {

		    $router->get('/category', 'CategoryController@listCategory');
		    $router->post('/category', 'CategoryController@createCategory');
		    $router->put('/category', 'CategoryController@updateCategory');
		    $router->delete('/category', 'CategoryController@deleteCategory');
		});
    });

});
