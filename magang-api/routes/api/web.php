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


$router->group(['prefix' => 'api'], function() use($router){
  $router->group(['prefix' => 'web'], function() use($router){
    $router->get('/favorit', 'Web\PublikController@getFavorit');
    $router->get('/lokasi', 'Web\PublikController@getLokasi');
    $router->get('/kategori', 'Web\PublikController@getKategori');

    // postingan magang
    $router->get('/postingan-magang', 'Web\PostinganMagangController@getAll');
    $router->get('/postingan-magang/{slug}', 'Web\PostinganMagangController@getSlug');
  });
});
