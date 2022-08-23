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
