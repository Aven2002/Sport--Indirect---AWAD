<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/test', function () {
    return ('welcome');
});

//Address
Route::get('/address/{id}/user',[AddressController::class,'getUserAddress']);
Route::post('/address/{id}/set-default', [AddressController::class, 'setDefault']);
Route::resource('address',AddressController::class);

//Cart
Route::get('/cart/{id}/user',[CartController::class,'getUserCartId']);
Route::resource('cart',CartController::class);

//Cart Detail
Route::resource('cartDetail',CartDetailController::class);

//Feedback
Route::get('/feedback/unread',[FeedbackController::class,'unreadCount']);
Route::resource('feedback',FeedbackController::class);

//Store
Route::resource('store',StoreController::class);

//Order
Route::resource('order',OrderController::class);

//Product
Route::get('/product/brand',[ProductController::class,'getProductBrand']);
Route::get('/product/category',[ProductController::class,'getProductCategory']);
Route::get('/product/sport/category',[ProductController::class,'getSportCategory']);
Route::get('/product/search-products', [ProductController::class, 'search']);
Route::resource('product',ProductController::class);

//User
Route::resource('user',UserController::class);
