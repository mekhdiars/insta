<?php

namespace App\Enums;

enum SubscribeState: string
{
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';
}
