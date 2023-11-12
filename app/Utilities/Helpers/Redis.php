<?php

namespace App\Utilities\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Redis as RedisFacade;

class Redis implements RedisHelperInterface
{
    function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress, string $messageBody): void
    {
        $key = 'simple-email-' . $id;
        $data = [
            'to' => $toEmailAddress,
            'subject' => $messageSubject,
            'body' => $messageBody,
            'created_at' => Carbon::now()
        ];

        RedisFacade::set($key, json_encode($data));
    }
}
