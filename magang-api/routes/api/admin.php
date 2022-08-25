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
  $router->group(['prefix' => 'admin'], function() use($router){
    $router->post('/login' , 'Admin\AuthController@getLogin');
    $router->post('/register' , 'Admin\AuthController@getRegister');
    
    $router->group(['middleware' => 'auth:users'], function() use($router){
      $router->get('/me' , 'Admin\AuthController@getMe');
      $router->get('/dashboard-panel' , 'Admin\Dashboard\DashboardController@getDashboard');

      // data
      $router->get('/kategori', 'Admin\KategoriMagangController@getList');
      $router->get('/kategori/{slug}', 'Admin\KategoriMagangController@getShowData');
      $router->post('/kategori/save', 'Admin\KategoriMagangController@getSave');
      $router->delete('/kategori/{kategoriId}/delete', 'Admin\KategoriMagangController@getDeleted');
      // lets try in postman

      $router->get('/lokasi', 'Admin\LokasiMagangController@getList');
      $router->get('/lokasi/{slug}', 'Admin\LokasiMagangController@getShowData');
      $router->post('/lokasi/save', 'Admin\LokasiMagangController@getSave');
      $router->delete('/lokasi/{lokasiId}/delete', 'Admin\LokasiMagangController@getDeleted');

      $router->get('/favorit', 'Admin\FavoritMagangController@getList');
      $router->get('/favorit/{slug}', 'Admin\FavoritMagangController@getShowData');
      $router->post('/favorit/save', 'Admin\FavoritMagangController@getSave');
      $router->delete('/favorit/{favoritId}/delete', 'Admin\FavoritMagangController@getDeleted');
      
      $router->get('/teknologi', 'Admin\TeknologiMagangController@getList');
      $router->get('/teknologi/{slug}', 'Admin\TeknologiMagangController@getShowData');
      $router->post('/teknologi/save', 'Admin\TeknologiMagangController@getSave');
      $router->delete('/teknologi/{favoritId}/delete', 'Admin\TeknologiMagangController@getDeleted');
    });
  });
});
