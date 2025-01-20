<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\UpdateUserData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'login' => ['nullable', 'string', 'max:254', 'unique:users,login,' . $this->user()->id],
            'email' => ['nullable', 'email', 'max:254', 'unique:users,email,' . $this->user()->id],
            'about' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed'],
        ];
    }

    public function data(): UpdateUserData
    {
        return UpdateUserData::from($this->validated());
    }
}
