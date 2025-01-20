<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\StorePostData;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => ['required', 'image', 'max:1024'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function data(): StorePostData
    {
        return StorePostData::from([
            'photo' => $this->file('photo'),
            'description' => $this->input('description')
        ]);
    }
}
