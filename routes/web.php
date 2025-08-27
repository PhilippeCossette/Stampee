<?php

use App\Routes\Route;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\StampController;
use App\Controllers\UserController;
use App\Controllers\AuctionController;
use App\Controllers\BidController;
use App\Controllers\FavoriteController;
use App\Models\Utilisateur;

Route::get('/', 'HomeController@index');


Route::get('/register', 'AuthController@registerIndex');
Route::post('/register', 'AuthController@registerAccount');

Route::get('/login', 'AuthController@loginIndex');
Route::post('/login', 'AuthController@login');

Route::get('/logout', 'AuthController@logout');

Route::get('/profile', 'UserController@profileIndex');

Route::get('/user/delete', 'UserController@deleteUser');

Route::get('/user/update', 'UserController@updateIndex');
Route::post('/user/update', 'UserController@updateUser');

Route::get('/create', 'StampController@createIndex');
Route::post('/create', 'StampController@storeStamp');

Route::get('/stamp/update', 'StampController@updateStampIndex');
Route::post('/stamp/update', 'StampController@updateStamp');

Route::post('/stamp/deleteImage', 'StampController@deleteImage');

Route::get('/auctionlist', 'AuctionController@auctionList');
Route::post('/auctionlist', 'AuctionController@auctionList');

Route::get('/auction', 'AuctionController@showAuction');

Route::get('/auction/bids', 'BidController@showAuctionBids');

Route::get('/bid', 'BidController@showBid');
Route::post('/bid/store', 'BidController@storeBid');

Route::post('/favorites/add', 'FavoriteController@addFavorite');
Route::post('/favorites/remove', 'FavoriteController@removeFavorite');

Route::post('/auction/comment', 'CommentController@createComment');
Route::post('/comment/delete', 'CommentController@deleteComment');

Route::get('/profile/favorites', 'UserController@profileFavorites');
Route::get('/profile/myAuctions', 'UserController@profileMyAuctions');
Route::get('/profile/myBids', 'BidController@showMyBidLog');

Route::dispatch();
