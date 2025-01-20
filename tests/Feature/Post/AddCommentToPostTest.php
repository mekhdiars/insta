<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddCommentToPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()
            ->for($this->getUser())
            ->has(
                Comment::factory()
                    ->for($this->getUser())
            )
            ->create();
    }

    public function test_add_comment_to_post(): void
    {
        $data = [
            'comment' => fake()->sentence()
        ];

        $response = $this->postJson(route('posts.comment', $this->post), $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'user' => [
                'id', 'name', 'avatar'
            ],
            'comment',
            'createdAt'
        ]);

        $response->assertJson([
            'comment' => $data['comment']
        ]);

        $this->assertDatabaseHas(Comment::class, [
            'id' => $response->json('id'),
            'post_id' => $this->post->id,
            'user_id' => $this->getUserId(),
            'comment' => $data['comment']
        ]);
    }
}
