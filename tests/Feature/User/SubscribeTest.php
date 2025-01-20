<?php

namespace Tests\Feature\User;

use App\Enums\SubscribeState;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    private User $unsubscribedUser;
    private User $subscribedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unsubscribedUser = User::factory()->create();
        $this->subscribedUser = User::factory()
            ->hasSubscriptions(1, ['subscriber_id' => $this->getUserId()])
            ->create();
    }

    public function test_subscribe_to_unsubscribe_user(): void
    {
        $response = $this->postJson(route('users.subscribe', $this->unsubscribedUser));

        $response->assertOk();
        $response->assertJson([
            'state' => SubscribeState::Subscribed->value
        ]);
    }

    public function test_unsubscribe_to_subscribe_user(): void
    {
        $response = $this->postJson(route('users.subscribe', $this->subscribedUser));

        $response->assertOk();
        $response->assertJson([
            'state' => SubscribeState::Unsubscribed->value
        ]);
    }
}
