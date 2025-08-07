<?php
use App\Routes\Route;

use App\Controllers\HomeController;
use App\Controllers\AuthController; 
use App\Models\Utilisateur;

Route::get('/', 'HomeController@index');


Route::get('/register', 'AuthController@index');
Route::post('/register', 'AuthController@registerAccount');





Route::dispatch();
?>