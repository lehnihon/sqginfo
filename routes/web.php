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
        $router->get('/dashboard','DashboardController@index')->name('dashboard');
        $router->get('/account','AccountController@index')->name('account');
        $router->get('/bank','BankController@index')->name('bank');
        $router->get('/transaction','TransactionController@index')->name('transaction');
        $router->group(['prefix' => 'config'], function() use ($router) {
            
        });
    }
);

