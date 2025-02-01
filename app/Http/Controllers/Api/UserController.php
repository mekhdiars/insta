<?php

namespace App\Http\Controllers\Api;

use App\Facades\User as UserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\GetPostsRequest;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Post\FeedPostResource;
use App\Http\Resources\User\CurrentUserResource;
use App\Http\Resources\User\SubscriberResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function user(): CurrentUserResource
    {
        return new CurrentUserResource(auth()->user());
    }

    public function avatar(UpdateAvatarRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserFacade::updateAvatar($request->avatar())
        );
    }

    public function update(UpdateUserRequest $request): CurrentUserResource
    {
        return new CurrentUserResource(
            UserFacade::update($request->data())
        );
    }

    public function getUser(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function subscribers(User $user): AnonymousResourceCollection
    {
        return SubscriberResource::collection($user->subscriptions);
    }

    public function subscribe(User $user): JsonResponse
    {
        return response()->json([
            'state' => $user->subscribe(),
        ]);
    }

    public function posts(GetPostsRequest $request, User $user): JsonResponse
    {
        $posts = UserFacade::posts($user, $request->limit, $request->offset);

        return response()->json([
            'posts' => FeedPostResource::collection($posts),
            'total' => $posts->count(),
        ]);
    }
}
