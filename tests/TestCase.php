<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private User $user;

    public function getUser(): User
    {
        return $this->user;
    }
    public function getUserId(): int
    {
        return $this->user->id;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['avatar' => null]);
        Sanctum::actingAs($this->user);
    }
}
