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
    return redirect('/products/');
});

// Product Routes
Route::get('/products/', 'ProductsController@index');
Route::post('/products/', 'ProductsController@store');
Route::get('/products/create', 'ProductsController@create');
Route::get('/products/{id}/edit', 'ProductsController@edit');
Route::post('/products/{id}', 'ProductsController@update');
Route::get('/products/{id}', 'ProductsController@show');
Route::get('/products/{id}/remove', 'ProductsController@destroy');

// Order Routes
Route::post('/orders/', 'OrdersController@store');
Route::get('/orders/', 'OrdersController@index');
Route::get('/orders/checkout', 'OrdersController@initCheckout');
Route::post('/orders/checkout', 'OrdersController@completeCheckout');