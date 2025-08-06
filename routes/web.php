<?php
use App\Routes\Route;

use App\Controllers\HomeController;
use App\Models\Utilisateur;

Route::get('/', 'HomeController@index');


Route::get('/register', 'AuthController@showForm');





Route::dispatch();
?>