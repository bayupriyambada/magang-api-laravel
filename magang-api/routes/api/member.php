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
      $router->get('/posts-intern', 'Member\PostinganMagangController@getList');
      $router->post('/posts-intern/save', 'Member\PostinganMagangController@getSave');
      $router->get('/posts-intern/{slug}', 'Member\PostinganMagangController@getSlug');
      $router->delete('/posts-intern/{postsInternId}/delete', 'Member\PostinganMagangController@getDeleted');
    });
  });
});
