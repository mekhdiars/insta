<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

function responseOk(int $code = 200): JsonResponse
{
    return response()->json([
        'status' => true,
    ], $code);
}

function responseFailed(?string $message = null, int $code = 400): JsonResponse
{
    return response()->json([
        'message' => __($message) ?? __('Bad request'),
    ], $code);
}

function uploadedImage(UploadedFile $image): string
{
    $image->storePublicly('avatars');
    return asset('storage/public/avatars/' . $image->hashName());
}
