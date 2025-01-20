<?php

namespace App\Providers;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\CurrentUserResource;
use App\Services\Post\PostService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserService::class);
        $this->app->bind(PostService::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CurrentUserResource::withoutWrapping();
        PostResource::withoutWrapping();
        CommentResource::withoutWrapping();
    }
}
