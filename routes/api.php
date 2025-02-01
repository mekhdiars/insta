<?php

use App\Models\Post;

require_once __DIR__ . '/groups/current_user.php';
require_once __DIR__ . '/groups/users.php';
require_once __DIR__ . '/groups/posts.php';

\Illuminate\Support\Facades\Route::get('/', function () {
    dd(Post::query()->where('id', 1)->with('user')->value('id'));
});
