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

      $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('/', 'Admin\CategoriesInternController@getList');
        $router->get('/{slug}', 'Admin\CategoriesInternController@getShowData');
        $router->post('/save', 'Admin\CategoriesInternController@getSave');
        $router->delete('/{categoryId}/delete', 'Admin\CategoriesInternController@getDeleted');

        // data delete to trash in db
        $router->get('/delete-permanent', 'Admin\CategoriesInternController@getDataTrash');
        $router->delete('/{categoryId}/delete-permanent', 'Admin\CategoriesInternController@getDeletePermanent');
      });

      $router->group(['prefix' => 'location'], function () use ($router) {
        $router->get('/', 'Admin\LocationController@getList');
        $router->get('/{slug}', 'Admin\LocationController@getShowData');
        $router->post('/save', 'Admin\LocationController@getSave');
        $router->delete('/{locationId}/delete', 'Admin\LocationController@getDeleted');
      });

      $router->group(['prefix' => 'technology'], function () use ($router) {
        $router->get('/', 'Admin\TeknologiMagangController@getList');
        $router->get('/{slug}', 'Admin\TeknologiMagangController@getShowData');
        $router->post('/save', 'Admin\TeknologiMagangController@getSave');
        $router->delete('/{technologyId}/delete', 'Admin\TeknologiMagangController@getDeleted');
      });
      $router->group(['prefix' => 'qualification'], function () use ($router) {
        $router->get('/', 'Admin\QualificationController@getList');
        $router->post('/save', 'Admin\QualificationController@getSave');
        $router->delete('/{qualificationId}/delete', 'Admin\QualificationController@getDeleted');
        $router->get('/delete-permanent', 'Admin\QualificationController@getDataTrash');
        $router->delete('/{qualificationId}/delete-permanent', 'Admin\QualificationController@getDeletePermanent');
      });
    });
  });
});
