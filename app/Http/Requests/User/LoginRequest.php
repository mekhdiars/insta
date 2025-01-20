<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\LoginData;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'password' => ['required'],
        ];
    }

    public function data(): LoginData
    {
        return LoginData::from($this->validated());
    }
}
