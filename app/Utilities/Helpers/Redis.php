<?php

namespace App\Utilities\Helpers;

use Carbon\Carbon;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;

class Redis implements RedisHelperInterface
{
    function storeRecentMessage(mixed $mailID, string $messageSubject, string $toEmailAddress, string $messageBody): void
    {
        Cache::store('redis')->put('simple-email-' . $mailID, [
            'mail_id' => $mailID,
            'subject' => $messageSubject,
            'to' => $toEmailAddress,
            'at' => Carbon::now(),
        ], Carbon::now()->addDays(7));
    }
}
