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
  $router->group(['prefix' => 'admin'], function () use ($router) {
    $router->post('/login', 'Admin\AuthController@getLogin');
    $router->post('/register', 'Admin\AuthController@getRegister');

    $router->group(['middleware' => 'auth:users'], function () use ($router) {
      $router->get('/me', 'Admin\AuthController@getMe');
      $router->get('/dashboard-panel', 'Admin\Dashboard\DashboardController@getDashboard');

      // data
      $router->get('/categories', 'Admin\KategoriMagangController@getList');
      $router->get('/categories/{slug}', 'Admin\KategoriMagangController@getShowData');
      $router->post('/categories/save', 'Admin\KategoriMagangController@getSave');
      $router->delete('/categories/{categoryId}/delete', 'Admin\KategoriMagangController@getDeleted');
      // lets try in postman

      $router->get('/location', 'Admin\LokasiMagangController@getList');
      $router->get('/location/{slug}', 'Admin\LokasiMagangController@getShowData');
      $router->post('/location/save', 'Admin\LokasiMagangController@getSave');
      $router->delete('/location/{lokasiId}/delete', 'Admin\LokasiMagangController@getDeleted');

      $router->get('/favorite', 'Admin\FavoritMagangController@getList');
      $router->get('/favorite/{slug}', 'Admin\FavoritMagangController@getShowData');
      $router->post('/favorite/save', 'Admin\FavoritMagangController@getSave');
      $router->delete('/favorite/{favoritId}/delete', 'Admin\FavoritMagangController@getDeleted');

      $router->get('/technology', 'Admin\TeknologiMagangController@getList');
      $router->get('/technology/{slug}', 'Admin\TeknologiMagangController@getShowData');
      $router->post('/technology/save', 'Admin\TeknologiMagangController@getSave');
      $router->delete('/technology/{technologyId}/delete', 'Admin\TeknologiMagangController@getDeleted');
    });
  });
});
