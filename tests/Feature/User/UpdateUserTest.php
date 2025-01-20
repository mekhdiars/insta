<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    public function test_success_update_user(): void
    {
        $data = [
            "name" => fake()->name,
            "login" => fake()->unique()->userName,
            "email" => fake()->unique()->safeEmail,
            "about" => 'Я умею делать крутой API на Laravel',
        ];
        $response = $this->patchJson(route('user.update'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'name', 'email', 'subscribers', 'publications', 'avatar', 'about', 'isVerified', 'registeredAt',
        ]);
        $response->assertJson([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'about' => $data['about'],
        ]);
        $this->assertDatabaseHas(User::class, [
            'id' => $this->getUserId(),
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'about' => $data['about'],
        ]);
    }
}
