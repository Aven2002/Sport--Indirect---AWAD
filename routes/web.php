<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin
Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/manage/products', 'admin.manageProducts.index')->name('admin.manageProducts');
Route::view('/admin/manage/accounts', 'admin.manageAccounts.index')->name('admin.manageAccounts');
Route::view('/admin/manage/feedbacks', 'admin.manageFeedbacks.index')->name('admin.manageFeedbacks');
Route::view('/admin/manage/orders', 'admin.manageOrders.index')->name('admin.manageOrders');
Route::view('/admin/manage/stores', 'admin.manageStores.index')->name('admin.manageStores');

//User
Route::view('/user/home', 'user.home')->name('user.home');
Route::view('/user/cart', 'user.cart')->name('user.cart');
Route::view('/user/address', 'user.address')->name('user.address');
Route::view('/user/checkout','user.checkout')->name('user.checkout');
Route::view('/user/store', 'user.store')->name('user.store');
Route::view('/user/product','user.product')->name('user.product');
Route::view('/user/product/detail/{id}','user.productDetail')->name('user.productDetail');
Route::view('/user/contactUs','user.contactUs')->name('user.contactUs');
Route::view('/user/aboutUs','user.aboutUs')->name('user.aboutUs');
Route::view('/user/help','user.help')->name('user.help');
Route::view('/user/order','user.order')->name('user.order');


//General 
Route::view('/', 'landing')->name('landing');
Route::view('/user/profile', 'profile')->name('user.profile');