<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'index', 'uses' => function () {
    return view('pages.index');
}]);


//Sales Invoice CRUD route
Route::get('invoices/quotation', ['as' => 'invoices.quotation', 'uses' => 'SalesInvoicesController@quotation']);
Route::resource('invoices', 'SalesInvoicesController');

Route::get('clients/search', ['as' => 'clients.search', 'uses' => 'ClientsController@search']);
Route::get('clients/filter', ['as' => 'clients.filter', 'uses' => 'ClientsController@filter']);
Route::resource('clients', 'ClientsController');

Route::get('suppliers/search', ['as' => 'suppliers.search', 'uses' => 'SuppliersController@search']);
Route::resource('suppliers', 'SuppliersController');

Route::get('items/search', ['as' => 'items.search', 'uses' => 'ItemsController@search']);
Route::resource('items','ItemsController');
Route::resource('reasons','ReasonsController',['except' => 'show']); 
 
Route::get('reports',['as'=>'reports.choose','uses'=>'ReportsController@choose']);   
Route::get('reports/generate',['as'=>'reports.generate','uses'=>'ReportsController@generate']);   
Route::get('reports/result',['as'=>'reports.result','uses'=>'ReportsController@result']);   

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('users', 'UsersController@index');
Route::delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);
Route::get('users/{id}/edit', ['as' => 'users.edit', 'uses' => 'UsersController@getUpdateAccount']);
Route::post('users/{id}', 'UsersController@postUpdateAccount');
Route::get('users/{id}', ['as' => 'users.show', 'uses' => 'UsersController@show']);