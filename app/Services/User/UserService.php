<?php

namespace App\Services\User;

use App\Exceptions\User\InvalidUserCredentialsException;
use App\Http\Resources\User\CurrentUserResource;
use App\Models\User;
use App\Services\User\Data\LoginData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UpdateUserData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class UserService
{
    public function store(RegisterUserData $data): CurrentUserResource
    {
        return new CurrentUserResource(
            User::query()
                ->create($data->toArray())
        );
    }

    /**
     * @throws InvalidUserCredentialsException
     */
    public function login(LoginData $data): array
    {
        if (!auth()->guard('web')->attempt($data->toArray())) {
            throw new InvalidUserCredentialsException('Invalid user credentials');
        }

        $token = auth()->user()->createToken('api_login');

        return ['token' => $token->plainTextToken];
    }

    public function updateAvatar(UploadedFile $avatar): User
    {
        auth()->user()->update([
            'avatar' => uploadedImage($avatar)
        ]);

        return auth()->user();
    }

    public function update(UpdateUserData $data): User
    {
        auth()->user()->update($data->toArray());

        return auth()->user();
    }

    public function posts(User $user, int $limit = 10, int $offset = 0): Collection
    {
        return $user->posts()
            ->limit($limit)
            ->offset($offset)
            ->orderByDesc('id')
            ->get();
    }
}
