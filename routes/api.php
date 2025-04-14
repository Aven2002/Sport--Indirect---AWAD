<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\StoreController;

Route::get('/test', function () {
    return ('welcome');
});

//Address
Route::resource('address',AddressController::class);
Route::get('/address/{id}/user',[AddressController::class,'getUserAddress']);

//Cart
Route::post('/cart',[CartController::class,'store']);
Route::delete('/cart/{id}',[CartController::class,'destroy']);
Route::get('/cart/{id}/user',[CartController::class,'getUserCartId']);

//Cart Detail
Route::resource('cartDetail',CartDetailController::class);

//Feedback
Route::resource('feedback',FeedbackController::class);

//Store
Route::resource('store',StoreController::class);
