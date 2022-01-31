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

// if necessary I can surround with middleware to authenticate theses routes.

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'insurance-quote'], function ($route) {
        $route->get('calculate', '\App\Api\InsuranceQuote\Controllers\InsuranceQuoteController@calculateRisk');
    });
});

