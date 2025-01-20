<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_post(): void
    {
        $data = [
            'photo' => UploadedFile::fake()->image('image.png'),
            'description' => fake()->sentence
        ];

        $response = $this->postJson(route('posts.store'), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'photo',
            'user',
            'description',
            'likes',
            'isLiked',
            'comments' => [
                'total',
                'list'
            ],
            'createdAt'
        ]);

        $response->assertJson([
            'photo' => asset('storage/public/avatars/' . $data['photo']->hashName()),
            'description' => $data['description'],
            'likes' => 0,
            'isLiked' => false,
            'comments' => [
                'total' => 0,
                'list' => [],
            ],
        ]);

        $this->assertDatabaseHas(Post::class, [
            'id' => $response->json('id'),
            'photo' => $response->json('photo'),
            'user_id' => $this->getUserId(),
            'description' => $response->json('description')
        ]);
    }
}
