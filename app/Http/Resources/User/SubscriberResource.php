<?php

namespace App\Http\Resources\User;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subscription */
class SubscriberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->subscriber->id,
            'name' => $this->subscriber->name,
            'login' => $this->subscriber->login,
            'avatar' => $this->subscriber->avatar,
            'isVerified' => $this->subscriber->is_verified,
            'isSubscribed' => $this->subscriber->isSubscribed(),
        ];
    }
}
