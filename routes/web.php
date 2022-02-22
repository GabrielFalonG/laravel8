<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;

Route::prefix('')->namespace('Auth')->group(function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login');
    });
});

Route::get('/',          [HomeController::class, 'index'])->name('index')->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');


Route::group(['prefix' => 'products', 'as' => 'product.', 'middleware' => 'auth'], function () {

    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::put('update/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('destroy', [ProductController::class, 'destroy'])->name('destroy');
});