<?php

namespace App\Services\Post\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StorePostData extends Data
{
    public function __construct(
        public UploadedFile $photo,
        public string|Optional $description
    ) {
    }
}
