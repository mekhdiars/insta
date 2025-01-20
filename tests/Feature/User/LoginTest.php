<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_success_auth_with_email(): void
    {
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    public function test_success_auth_with_login(): void
    {
        $response = $this->postJson(route('user.login'), [
            'login' => $this->user->login,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }
}
