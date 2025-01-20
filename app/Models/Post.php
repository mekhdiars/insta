<?php

namespace App\Models;

use App\Enums\LikeState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function totalComments(): int
    {
        return $this->comments()->count();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function totalLikes(): int
    {
        return $this->likes()->count();
    }

    public function isLiked(): bool
    {
        return $this->likes()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function like(): LikeState
    {
        $like = $this->likes()
            ->where('user_id', auth()->id());

        if ($like->exists()) {
            $like->delete();
            return LikeState::Unliked;
        }

        $like->create([
            'user_id' => auth()->id()
        ]);

        return LikeState::Liked;
    }
}
