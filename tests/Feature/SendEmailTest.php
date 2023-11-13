<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\SendAnEmail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SendEmailTest extends TestCase
{
    use DatabaseTransactions;

    private $validData;
    private $inValidData;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->validData = [
            [
                "subject" => "Subject",
                "email" => "email@test.com",
                "body" => "Email body"
            ],
            [
                "subject" => "Subject",
                "email" => "email@test.com",
                "body" => "Email body"
            ]
        ];
        
        $this->inValidData = [
            [
                "email" => "email@test.com",
                "body" => "Email body"
            ],
            [
                "subject" => "Subject",
                "email" => "email@test.com",
                "body" => "Email body"
            ]
        ];
    }

    public function test_able_to_send_email(): void
    {
        Queue::fake();

        $user = User::all()->first();

        $apiToken = config('auth.api.token');

        $response = $this->postJson('/api/' . $user->id . '/send?api_token=' . $apiToken, [
            'emails' => $this->validData
        ]);
        $response->assertStatus(200);
        
        Queue::assertPushed(SendAnEmail::class, count($this->validData));
    }

    public function test_unable_to_send_email_failed_validation(): void
    {
        Queue::fake();

        $user = User::all()->first();

        $apiToken = config('auth.api.token');
        
        $response = $this->postJson('/api/' . $user->id . '/send?api_token=' . $apiToken, [
            'emails' => $this->inValidData
        ]);
        $response->assertStatus(422);
        
        Queue::assertNotPushed(SendAnEmail::class);
    }
}
