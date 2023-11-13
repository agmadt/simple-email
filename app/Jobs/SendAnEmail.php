<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Utilities\Helpers\Redis;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Utilities\Helpers\ElasticSearch;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAnEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $mailID = (string) Str::ulid();

        $email = new SendEmail(
            id: $mailID,
            user_name: $this->data['user_name'],
            user_email: $this->data['user_email'],
            email: $this->data['email'],
            subject: $this->data['subject'],
            body: $this->data['body']
        );

        Mail::to($this->data['email'])->send($email);

        $es = new ElasticSearch();
        $es->storeEmail(
            mail: $email
        );

        $redis = new Redis();
        $redis->storeRecentMessage(
            mail: $email
        );
    }
}
