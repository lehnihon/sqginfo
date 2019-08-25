<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->group(
    ['middleware' => 'auth:api'], 
    function() use ($router) {
        $router->group(['prefix' => 'account'], function() use ($router) {
            $router->get('/','AccountController@show');
            $router->post('/','AccountController@store');
            $router->delete('/{id}','AccountController@destroy');
        });
        $router->group(['prefix' => 'bank'], function() use ($router) {
            $router->get('/','BankController@show');
            $router->post('/','BankController@store');
            $router->delete('/{id}','BankController@destroy');
        });
        $router->group(['prefix' => 'transaction'], function() use ($router) {
            $router->get('/','TransactionController@show');
            $router->post('/','TransactionController@store');
            $router->get('/{id}','TransactionController@edit');
            $router->put('/','TransactionController@update');
            $router->delete('/{id}','TransactionController@destroy');
        });
    }
);

