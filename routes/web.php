<?php
// Import the Route class from the Routes namespace
use App\Routes\Route;

// Import the ClientController class from the Controllers namespace
use App\Controllers\ClientController;
// Import the UserController class from the Controllers namespace
use App\Controllers\UserController;
// Import the AuthController class from the Controllers namespace
use App\Controllers\AuthController;

// Define a route for the GET request to '/clients', which calls the 'index' method of ClientController
Route::get('/', 'ClientController@index');

// Define a route for the GET request to '/client/show', which calls the 'show' method of ClientController
Route::get('/client/show', 'ClientController@show');

// Define a route for the GET request to '/client/create', which calls the 'create' method of ClientController
Route::get('/client/create', 'ClientController@create');

// Define a route for the POST request to '/client/create', which calls the 'store' method of ClientController
Route::post('/client/create', 'ClientController@store');

// Define a route for the GET request to '/client/edit', which calls the 'edit' method of ClientController
Route::get('/client/edit', 'ClientController@edit');

// Define a route for the POST request to '/client/edit', which calls the 'update' method of ClientController
Route::post('/client/edit', 'ClientController@update');

// Define a route for the POST request to '/client/delete', which calls the 'delete' method of ClientController
Route::post('/client/delete', 'ClientController@delete');

// Define a route for the GET request to '/user/create', which calls the 'create' method of ClientController\
Route::get('/user/create', 'UserController@create');
// Define a route for the POST request to '/user/create', which calls the 'store' method of ClientController
Route::post('/user/create', 'UserController@store');

Route::get('/login', 'AuthController@index');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

Route::get('/logs', 'LogController@index');

// Dispatch the routes (route matching and handling requests)
Route::dispatch();

?>
