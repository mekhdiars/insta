<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::controller(UserController::class)
    ->prefix('users')
    ->as('users.')
    ->group(function () {
        Route::get('/{user}', 'getUser')
            ->name('get-user');
        Route::get('/{user}/subscribers', 'subscribers')
            ->name('subscribers');
        Route::post('/{user}/subscribe', 'subscribe')
            ->name('subscribe');
        Route::get('{user}/posts', 'posts')
            ->name('posts');
    });
