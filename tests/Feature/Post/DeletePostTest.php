<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;
    private Post $someonePost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->getUserId()
        ]);

        $this->someonePost = Post::factory()
            ->for(User::factory())
            ->create();
    }

    public function test_delete_post(): void
    {
        $response = $this->deleteJson(route('posts.destroy', $this->post));

        $response->assertNoContent();
        $this->assertDatabaseMissing(Post::class, [
            'id' => $this->post->id
        ]);
    }

    public function test_delete_someone_post(): void
    {
        $response = $this->deleteJson(route('posts.destroy', $this->someonePost));

        $response->assertForbidden();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas(Post::class, [
            'id' => $this->someonePost->id
        ]);
    }
}
