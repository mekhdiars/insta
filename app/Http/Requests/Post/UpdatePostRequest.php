<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\UpdatePostData;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function data(): UpdatePostData
    {
        return UpdatePostData::from($this->validated());
    }
}
