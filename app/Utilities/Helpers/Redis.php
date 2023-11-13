<?php

namespace App\Utilities\Helpers;

use App\Mail\SendEmail;
use Carbon\Carbon;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Support\Facades\Cache;

class Redis implements RedisHelperInterface
{
    function storeRecentMessage(SendEmail $mail): void
    {
        Cache::store('redis')->put('simple-email-' . $mail->id, [
            'id' => $mail->id,
            'subject' => $mail->subject,
            'email' => $mail->email,
            'body' => $mail->body,
            'user_name' => $mail->user_name,
            'user_email' => $mail->user_email,
            'created_at' => Carbon::now(),
        ], Carbon::now()->addDays(7));
    }
}
