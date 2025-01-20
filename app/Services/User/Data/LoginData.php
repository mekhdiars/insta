<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class LoginData extends Data
{
    public function __construct(
        public string|Optional $login,
        public string|Optional $email,
        public string $password
    ) {
    }
}
