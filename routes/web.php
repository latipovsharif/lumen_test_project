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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('recipes',  ['uses' => 'RecipeController@showAll']);
  $router->get('recipes/{id}', ['uses' => 'RecipeController@show']);
  $router->post('recipes', ['uses' => 'RecipeController@create']);
  $router->delete('recipes/{id}', ['uses' => 'RecipeController@delete']);
  $router->put('recipes/{id}', ['uses' => 'RecipeController@update']);

  $router->post('create', ['uses' => 'UserController@create']);
  $router->post('get_token', ['uses' => 'UserController@authenticate']);

  $router->post('images/upload', ['uses' => 'ImageController@upload']);
});
