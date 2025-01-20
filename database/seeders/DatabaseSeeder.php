<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)
            ->has(
                Post::factory(3)
                ->has(Comment::factory(4)
                    ->for(User::factory()))
                ->has(Like::factory(10)
                    ->for(User::factory()))
            )->create();

        $users = User::all();

        $subscriptions = $users->flatMap(function ($user) {
            return User::query()
                ->inRandomOrder()
                ->take(rand(1, 30))
                ->get()
                ->map(function ($randomUser) use ($user) {
                    return [
                        'user_id' => $user->id,
                        'subscriber_id' => $randomUser->id,
                    ];
                });
        })->toArray();

        Subscription::query()->insert($subscriptions);
    }
}
