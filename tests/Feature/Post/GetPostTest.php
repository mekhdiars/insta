<?php

namespace Tests\Feature\Post;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->getUserId()
        ]);
    }

    public function test_get_post(): void
    {
        $response = $this->getJson(route('posts.show', $this->post));

        $response->assertOk();
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
            'photo' => $this->post->photo,
            'description' => $this->post->description,
            'likes' => $this->post->totalLikes(),
            'isLiked' => $this->post->isLiked(),
            'comments' => [
                'total' => $this->post->totalComments(),
                'list' => CommentResource::collection($this->post->comments)
                    ->toArray(request()),
            ],
        ]);
    }
}
