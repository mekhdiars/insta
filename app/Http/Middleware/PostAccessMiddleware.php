<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PostAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $post = $request->route('post');
        $isPostOwner = $post->user->is(auth()->user());

        if (! $isPostOwner) {
            return responseFailed('No access', 403);
        }

        return $next($request);
    }
}
