<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$path = 'App\Http\Controllers\Api\V1\\';

$api->version('v1', ['middleware' => 'bindings'], function ($api) use ($path) {

    $api->post('register', $path . 'AuthorizationController@register');
    $api->post('login', $path . 'AuthorizationController@login');

    $api->group(['middleware' => 'auth:api'], function($api) use ($path) {
        $api->post('logout', $path . 'AuthorizationController@logout');

        $api->put('users/{user}/confirm', $path . 'UserController@confirm');
        $api->get('users/{user}/businesses', $path . 'UserController@userBusinnesses');

        $api->resource('users', $path . 'UserController');

        $api->post('businesses/{business}', $path . 'BusinessController@update');
        $api->resource('businesses', $path . 'BusinessController');

    });
});
