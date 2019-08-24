<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

$router->group(
    ['middleware' => 'auth'], 
    function() use ($router) {
        $router->get('/home','HomeController@index')->name('home');
        $router->group(['prefix' => 'config'], function() use ($router) {
            
        });
    }
);

