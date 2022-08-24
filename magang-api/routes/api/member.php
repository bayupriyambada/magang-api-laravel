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


$router->group(['prefix' => 'api'],function() use($router){
  $router->group(['prefix' => 'member'], function() use($router){
    $router->post('/login' , 'Member\AuthController@getLogin');
    $router->post('/register' , 'Member\AuthController@getRegister');
    
    $router->group(['middleware' => 'auth:members'], function() use($router){
      $router->get('/me' , 'Member\AuthController@getMe');
      // data
      $router->get('/postingan-magang' , 'Member\PostinganMagangController@getList');
      $router->post('/postingan-magang/save' , 'Member\PostinganMagangController@getSave');
      $router->delete('/postingan-magang/{postinganMagangId}/delete' , 'Member\PostinganMagangController@getDeleted');
    });
  });
});
