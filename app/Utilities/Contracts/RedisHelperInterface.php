<?php

namespace App\Utilities\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RedisHelperInterface {
    /**
     * Store the id of a message along with a message subject in Redis.
     *
     * @param  mixed  $mailID
     * @param  string  $messageSubject
     * @param  string  $toEmailAddress
     * @return void
     */
    public function storeRecentMessage(mixed $mailID, string $messageSubject, string $toEmailAddress, string $messageBody): void;
}
