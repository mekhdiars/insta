<?php

namespace Tests\Feature\Post;

use App\Enums\LikeState;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $likedPost;
    private Post $unlikedPost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->likedPost = Post::factory()
            ->for($this->getUser())
            ->has(
                Like::factory()
                    ->for($this->getUser())
            )
            ->create();

        $this->unlikedPost = Post::factory()
            ->for($this->getUser())
            ->create();
    }

    public function test_like_post(): void
    {
        $response = $this->postJson(route('posts.like', $this->unlikedPost));

        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson([
            'state' => LikeState::Liked->value
        ]);

        $this->assertDatabaseHas(Like::class, [
            'post_id' => $this->unlikedPost->id,
            'user_id' => $this->getUserId()
        ]);
    }

    public function test_unlike_post(): void
    {
        $response = $this->postJson(route('posts.like', $this->likedPost));

        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson([
            'state' => LikeState::Unliked->value
        ]);

        $this->assertDatabaseMissing(Like::class, [
            'post_id' => $this->likedPost->id,
            'user_id' => $this->getUserId()
        ]);
    }
}
