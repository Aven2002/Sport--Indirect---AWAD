<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{view}',[ViewController::class,'show']);