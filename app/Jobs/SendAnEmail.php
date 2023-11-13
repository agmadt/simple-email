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
        Mail::to($this->data['email'])->send(new SendEmail(
            user_email: $this->data['user_email'],
            user_name: $this->data['user_name'],
            subject: $this->data['subject'],
            body: $this->data['body']
        ));

        $es = new ElasticSearch();
        $es->storeEmail(
            messageBody: $this->data['body'],
            messageSubject: $this->data['subject'],
            toEmailAddress: $this->data['email']
        );

        $redis = new Redis();
        $redis->storeRecentMessage(
            id: Str::ulid(),
            messageSubject: $this->data['subject'],
            toEmailAddress: $this->data['email'],
            messageBody: $this->data['body']
        );
    }
}
