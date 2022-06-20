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

$router->group(['prefix' => 'authentication'], function () use ($router) {
    $router->post('/', 'Authentication\AuthenticateController@basic');

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->get('/jwt', 'Authentication\AuthenticateController@jwt');
    });
});

$router->group(['prefix' => 'users', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/', 'UsersController@view');
});

$router->group(['prefix' => 'stations'], function () use ($router) {

    $router->post('/sendWeatherData', 'WeatherStationsController@receive');
    $router->get('/getWeatherData', 'WeatherStationsController@get');
    $router->get('/getStations', 'WeatherStationsController@getStations');
    $router->get('/getWeatherData/{station_name}', 'WeatherStationsController@showStation');
    $router->get('/getLowestTemperatures', 'WeatherStationsController@getLowestTemperatures');
    $router->get('/getPeakWindSpeeds', 'WeatherStationsController@getPeakWindspeeds');
    $router->get('/getExport', 'WeatherStationsController@getXmlExport');
});
