<?php

namespace App\Utilities\Contracts;

use App\Mail\SendEmail;
use Illuminate\Database\Eloquent\Model;

interface RedisHelperInterface {
    /**
     * Store the id of a message along with a message subject in Redis.
     *
     * @param  SendMail  $email
     * @return void
     */
    public function storeRecentMessage(SendEmail $mail): void;
}
