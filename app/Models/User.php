<?php

namespace App\Models;

use App\Enums\SubscribeState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'login',
        'password',
        'avatar',
        'about',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->with('subscriber');
    }

    public function subscriptionsCount(): int
    {
        return $this->subscriptions()->count();
    }

    public function postsCount(): int
    {
        return $this->posts()->count();
    }

    public function isSubscribed(): bool
    {
        return $this->subscriptions()
            ->where('subscriber_id', auth()->id())
            ->exists();
    }

    public function subscribe(): SubscribeState
    {
        $subscription = Subscription::query()
            ->where('user_id', $this->id)
            ->where('subscriber_id', auth()->id());

        if ($subscription->exists()) {
            $subscription->delete();

            return SubscribeState::Unsubscribed;
        }

        $subscription->create([
            'user_id' => $this->id,
            'subscriber_id' => auth()->id(),
        ]);

        return SubscribeState::Subscribed;
    }

    public function feedPosts(): HasManyThrough
    {
        return $this->hasManyThrough(
            Post::class,
            Subscription::class,
            'subscriber_id',
            'user_id',
            'id',
            'user_id'
        );
    }
}
