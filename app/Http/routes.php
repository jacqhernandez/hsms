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
Route::get('invoices/search', ['as' => 'invoices.search', 'uses' => 'SalesInvoicesController@search']);
Route::get('invoices/filter', ['as' => 'invoices.filter', 'uses' => 'SalesInvoicesController@filter']);
Route::get('invoices/quotation', ['as' => 'invoices.quotation', 'uses' => 'SalesInvoicesController@quotation']);
Route::get('invoices/make/{id}', ['as' => 'invoices.make', 'uses' => 'SalesInvoicesController@make']);
Route::post('invoices/creation', ['as' => 'invoices.creation', 'uses' => 'SalesInvoicesController@creation']);
Route::get('invoices/{invoices}/generate', ['as' => 'invoices.generate_pdf', 'uses' => 'SalesInvoicesController@generatePdf']);
Route::get('invoices/{invoices}/edit_status',['as' => 'invoices.edit_status', 'uses' => 'SalesInvoicesController@editStatus']);
Route::get('invoices/{invoices}/po_guide', ['as' => 'invoices.po_guide', 'uses' => 'SalesInvoicesController@poGuide']);


Route::resource('invoices', 'SalesInvoicesController');
Route::resource('pricelogs', 'PriceLogsController');
Route::resource('invoiceitems', 'InvoiceItemsController');


Route::get('clients/search', ['as' => 'clients.search', 'uses' => 'ClientsController@search']);
Route::get('clients/filter', ['as' => 'clients.filter', 'uses' => 'ClientsController@filter']);
Route::resource('clients', 'ClientsController');

Route::get('suppliers/search', ['as' => 'suppliers.search', 'uses' => 'SuppliersController@search']);
Route::resource('suppliers', 'SuppliersController');

Route::get('items/search', ['as' => 'items.search', 'uses' => 'ItemsController@search']);
Route::resource('items','ItemsController');
Route::resource('reasons','ReasonsController',['except' => 'show']); 

Route::resource('collectibles', 'CollectiblesController', ['except' => 'update', 'edit', 'show', 'destroy']);
Route::resource('collectibles.collection_logs', 'CollectionLogsController', ['except' => 'update', 'edit']);
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

Route::get('reports', 'ReportsController@index');
Route::get('reports/generate', ['as' => 'reports.generate', 'uses' => 'ReportsController@generate']);
Route::post('reports/generate', 'ReportsController@generate');

Route::get('/home', 'DashboardController@index');
Route::get('/home/Collected', 'SalesInvoicesController@viewCollected');
Route::get('/home/CurrentCollectibles', 'SalesInvoicesController@viewCollectibles');
Route::get('/home/UpcomingCollectibles', 'SalesInvoicesController@viewUpcoming');
Route::get('/home/OverdueCollectibles', 'SalesInvoicesController@viewOverdue');


Route::get('logs', 'LogsController@index');
Route::get('logs/filter', ['as' => 'logs.filter', 'uses' => 'LogsController@filter']);
Route::get('logs/delete', ['as' => 'logs.delete', 'uses' => 'LogsController@deleteOldestFiftyActivities']);

// Route::post('collection_log/{id}', ['as' => 'collection_logs.update', 'uses' => 'DashboardController@viewToDo']);
// Route::get('/getRequest', function(){

// 	if(Request::ajax())
// 	{
// 		$date = $_GET['date'];
// 		return 'getRequest has loaded completely' . $date;
// 	}
// });

Route::get('/getRequest', ['as' => 'request', 'uses' => 'DashboardController@dateLog']);
//Route::PUT('/mark/{id}', ['as' => 'collection_logs.update', 'uses' => 'DashboardController@mark']);
Route::resource('collection_logs', 'DashboardController', ['except' => 'store', 'edit', 'show', 'destroy']);