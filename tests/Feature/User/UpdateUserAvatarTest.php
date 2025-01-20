<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateUserAvatarTest extends TestCase
{
    public function test_success_update_avatar(): void
    {
        $response = $this->postJson(route('user.avatar'), [
            'avatar' => UploadedFile::fake()
                ->image('avatar.jpg')
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id', 'name', 'email', 'subscribers', 'publications', 'avatar', 'about', 'isVerified', 'registeredAt',
        ]);
        $this->assertIsString($response->json('avatar'));
        $this->assertDatabaseHas(User::class, [
            'id' => $this->getUserId(),
            'avatar' => $this->getUser()->avatar
        ]);
    }

    public function test_update_avatar_validation(): void
    {
        $response = $this->postJson(route('user.avatar'), [
            'avatar' => UploadedFile::fake()
                ->image('avatar.gif')
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['avatar']);
    }
}
