<?php

namespace App\Services\User\Data;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Data;

class RegisterUserData extends Data
{
    public function __construct(
        public string $name,
        public string $login,
        public string $email,
        public string $password
    ) {
    }
}
