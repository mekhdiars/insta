<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::post('/register', RegisterController::class)
        ->name('register');
    Route::post('/login', LoginController::class)
        ->name('login');

    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'user')->name('current');
        Route::post('/avatar', 'avatar')->name('avatar');
        Route::patch('/', 'update')->name('update');
    });
});
