<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\MinifiedUserResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new MinifiedUserResource($this->user),
            'comment' => $this->comment,
            'createdAt' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
