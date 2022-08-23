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

$router->get('/kategori', 'Admin\KategoriMagangController@getList');
$router->post('/kategori/save', 'Admin\KategoriMagangController@getSave');
$router->delete('/kategori/{uuid}/deleted', 'Admin\KategoriMagangController@getDeleted');
// lets try in postman

$router->get('/lokasi', 'Admin\LokasiMagangController@getList');
$router->post('/lokasi/save', 'Admin\LokasiMagangController@getSave');
$router->delete('/lokasi/{uuid}/deleted', 'Admin\LokasiMagangController@getDeleted');

$router->get('/favorit', 'Admin\FavoritMagangController@getList');
$router->post('/favorit/save', 'Admin\FavoritMagangController@getSave');
$router->delete('/favorit/{uuid}/deleted', 'Admin\FavoritMagangController@getDeleted');
