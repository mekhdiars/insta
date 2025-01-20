<?php

namespace App\Http\Controllers\Api;

use App\Facades\Post as PostFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\AddCommentRequest;
use App\Http\Requests\Post\GetPostsRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\FeedPostResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('post.access')
            ->only(['update', 'destroy']);
    }

    public function index(GetPostsRequest $request)
    {
        $posts = PostFacade::feed($request->limit, $request->offset);

        return response()->json([
            'posts' => FeedPostResource::collection($posts),
            'total' => $posts->count()
        ]);
    }

    public function store(StorePostRequest $request): PostResource
    {
        return new PostResource(
            PostFacade::store($request->data())
        );
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        return new PostResource(
            PostFacade::update($post, $request->data())
        );
    }

    public function destroy(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }

    public function like(Post $post): JsonResponse
    {
        return response()->json([
            'state' => $post->like()
        ]);
    }

    public function addComment(AddCommentRequest $request, Post $post): CommentResource
    {
        return new CommentResource(
            $post->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $request->data()->comment
            ])
        );
    }
}
