<?php

namespace App\Http\Controllers\Api;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        return User::login($request->data());
    }
}
