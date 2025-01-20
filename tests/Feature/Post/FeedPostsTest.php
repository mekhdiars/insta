<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedPostsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();

        Post::factory(3)
            ->for($this->user)
            ->has(
                Like::factory()
                    ->for($this->getUser())
            )
            ->has(
                Comment::factory()
                    ->for($this->getUser())
            )
            ->create();

        $this->user->subscriptions()->create([
            'subscriber_id' => $this->getUserId(),
        ]);
    }

    public function test_get_feed_posts(): void
    {
        $limit = 10;
        $offset = 0;

        $response = $this->getJson(route('posts.index', [
            'limit' => $limit,
            'offset' => $offset,
        ]));

        $response->assertOk();
        $response->assertJsonStructure([
            'posts' => [
                '*' => [
                    'id',
                    'photo',
                    'user' => [
                        'id', 'name', 'avatar'
                    ],
                    'description',
                    'likes',
                    'isLiked',
                    'comments',
                    'createdAt',
                ],
            ],
            'total',
        ]);

        $post = Post::query()->orderByDesc('id')->first();
        $this->assertEquals($post->id, $response->json('posts.0.id'));
        $this->assertEquals($post->totalLikes(), $response->json('posts.0.likes'));
        $this->assertEquals($post->totalComments(), $response->json('posts.0.comments'));
    }

    public function test_get_feed_posts_with_invalid_limit_or_offset(): void
    {
        $response = $this->getJson(route('posts.index', [
            'limit' => -1,
            'offset' => -1,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['limit', 'offset']);
    }
}
