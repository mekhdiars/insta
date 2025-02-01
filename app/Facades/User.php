<?php

namespace App\Facades;

use App\Services\User\Data\LoginData;
use App\Services\User\Data\RegisterUserData;
use App\Services\User\Data\UpdateUserData;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\User store(RegisterUserData $data)
 * @method static array login(LoginData $data)
 * @method static \App\Models\User updateAvatar(UploadedFile $avatar)
 * @method static \App\Models\User update(UpdateUserData $data)
 * @method static Collection posts(\App\Models\User $user, int $limit = 10, int $offset = 0)
 *
 * @see UserService
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UserService::class;
    }
}
