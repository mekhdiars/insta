<?php

namespace Tests\Feature\Post;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->getUserId()
        ]);
    }

    public function test_update_post(): void
    {
        $data = [
            'description' => 'new description'
        ];

        $response = $this->patchJson(route('posts.update', $this->post), $data);

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
            'description' => $data['description'],
            'likes' => $this->post->totalLikes(),
            'isLiked' => $this->post->isLiked(),
            'comments' => [
                'total' => $this->post->totalComments(),
                'list' => CommentResource::collection($this->post->comments)
                    ->toArray(request()),
            ],
        ]);

        $this->assertDatabaseHas(Post::class, [
            'id' => $this->post->id,
            'description' => $data['description']
        ]);
    }
}
