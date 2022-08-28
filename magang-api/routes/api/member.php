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


$router->group(['prefix' => 'api'], function () use ($router) {
  $router->group(['prefix' => 'member'], function () use ($router) {
    $router->post('/login', 'Member\AuthController@getLogin');
    $router->post('/register', 'Member\AuthController@getRegister');

    $router->group(['middleware' => 'auth:members'], function () use ($router) {
      $router->get('/me', 'Member\AuthController@getMe');
      // data

      $router->group(['prefix' => 'posts-intern'], function () use ($router) {
        $router->get('/', 'Member\PostsInternController@getList');
        $router->post('/save', 'Member\PostsInternController@getSave');
        $router->get('/{slug}/detail', 'Member\PostsInternController@getSlug');
        $router->delete('/{postsInternId}/delete', 'Member\PostsInternController@getDeleted');
      });
    });
  });
});
