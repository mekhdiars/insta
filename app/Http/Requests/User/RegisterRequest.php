<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\RegisterUserData;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:254', 'unique:users'],
            'login' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function data(): RegisterUserData
    {
        return RegisterUserData::from($this->validated());
    }
}
