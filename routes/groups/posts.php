<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);

Route::controller(PostController::class)
    ->prefix('posts')
    ->as('posts.')
    ->group(function () {
        Route::post('{post}/like', 'like')
            ->name('like');
        Route::post('{post}/comment', 'addComment')
            ->name('comment');
    });
