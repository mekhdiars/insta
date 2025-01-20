<?php

namespace App\Services\Post\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdatePostData extends Data
{
    public function __construct(
        public string|Optional $description
    ) {
    }
}
