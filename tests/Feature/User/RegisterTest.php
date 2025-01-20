<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_validation(): void
    {
        $response = $this->postJson(route('user.register'), [
            'name' => null,
            'login' => null,
            'email' => 'mekhdiarsgmail.com',
            'password' => 'asdfasdf',
            'password_confirmation' => 'asd',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'login', 'email', 'password']);
    }

    public function test_register_success(): void
    {
        $data = [
            'name' => fake()->name,
            'login' => fake()->unique()->userName,
            'email' => fake()->unique()->safeEmail(),
            'password' => 'asdfasdf',
            'password_confirmation' => 'asdfasdf',
        ];

        $response = $this->postJson(route('user.register'), $data);
        $response->assertCreated();
        $response->assertJsonStructure([
            'id', 'name', 'email', 'subscribers', 'publications', 'avatar', 'about', 'isVerified', 'registeredAt',
        ]);

        $response->assertJson([
            'name' => $data['name'],
            'email' => $data['email'],
            'subscribers' => 0,
            'publications' => 0,
            'avatar' => null,
            'about' => null,
            'isVerified' => false,
        ]);

        $id = $response->json('id');
        $this->assertDatabaseHas(User::class, [
            'id' => $id,
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
        ]);

        $this->assertTrue(
            Hash::check($data['password'], User::query()->find($id)->password)
        );
    }
}
