<?php
use App\Routes\Route;

use App\Controllers\HomeController;
use App\Controllers\AuthController; 
use App\Controllers\UserController;
use App\Models\Utilisateur;

Route::get('/', 'HomeController@index');


Route::get('/register', 'AuthController@registerIndex');
Route::post('/register', 'AuthController@registerAccount');

Route::get('/login', 'AuthController@loginIndex');
Route::post('/login', 'AuthController@login');

Route::get('/logout', 'AuthController@logout');

Route::get('/profile', 'UserController@profileIndex');





Route::dispatch();
?>