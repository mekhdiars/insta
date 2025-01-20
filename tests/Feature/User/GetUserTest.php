<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->subscriptions()->create([
            'subscriber_id' => $this->getUserId()
        ]);
    }

    public function test_get_user(): void
    {
        $response = $this->getJson(route('users.get-user', $this->user));

        $response->assertOk();
        $response->assertJsonStructure([
            'id', 'name', 'email', 'subscribers', 'publications', 'avatar', 'about', 'isVerified',
            'registeredAt', 'isSubscribed'
        ]);
        $this->assertTrue($response->json('isSubscribed'));
    }
}
