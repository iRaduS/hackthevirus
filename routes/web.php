<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('location', ['as' => 'location', 'uses' => 'LocationController@location']);
$router->post('register', ['as' => 'register', 'uses' => 'AuthController@register']);
$router->post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
$router->get('my-user', ['as' => 'my-user', 'uses' => 'AuthController@my_user', 'middleware' => 'auth']);
$router->get('leaderboard', ['as' => 'leaderboard', 'uses' => 'EntityController@leaderboard']);
$router->get('shop', ['as' => 'shop', 'uses' => 'ShopController@shop']);
$router->post('shop/buy/{id}', ['as' => 'shop_buy', 'uses' => 'ShopController@shop_buy']);