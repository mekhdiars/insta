<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function store(StorePostData $data): Post
    {
        return auth()->user()->posts()->create([
            'photo' => uploadedImage($data->photo),
            'description' => $data->description
        ]);
    }

    public function update(Post $post, UpdatePostData $data): Post
    {
        $post->update($data->toArray());

        return $post;
    }

    public function feed(int $limit = 10, int $offset = 0): Collection
    {
        return auth()->user()
            ->feedPosts()
            ->limit($limit)
            ->offset($offset)
            ->orderByDesc('id')
            ->get();
    }
}
