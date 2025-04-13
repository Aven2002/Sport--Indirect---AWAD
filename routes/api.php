<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

Route::get('/test', function () {
    return ('welcome');
});

//Address
Route::resource('address',AddressController::class);
Route::get('/address/{id}/user',[AddressController::class,'getUserAddress']);

