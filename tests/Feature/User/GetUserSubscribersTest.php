<?php

namespace Tests\Feature\User;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserSubscribersTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->has(
                Subscription::factory(5)
                    ->for(User::factory(), 'subscriber')
            )
            ->create();
    }

    public function test_get_subscribers()
    {
        $response = $this->getJson(route('users.subscribers', $this->user));

        $response->assertOk();
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'login', 'avatar', 'isVerified', 'isSubscribed']
        ]);
    }
}
