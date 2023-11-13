<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;
use MailerLite\LaravelElasticsearch\Facade as MailerLiteElasticSearch;

class ListEmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_able_to_list_all_email()
    {
        $apiToken = config('auth.api.token');

        $data = [
            'index' => 'simple-email',
            'id' => (string) Str::ulid(),
            'type' => '_doc',
            'body' => [
                'email' => '_test+email@gmail.com',
                'subject' => '_testSubject',
                'body' => '_testBody',
                'created_at' => Carbon::now()
            ]
        ];

        MailerLiteElasticSearch::index($data);
        
        $response = $this->getJson('/api/list?api_token=' . $apiToken);
        $response->assertStatus(200);

        $data = $response->json();
        $this->assertArrayHasKey('emails', $data['data']);
        $this->assertArrayHasKey('email', $data['data']['emails'][0]);
        $this->assertArrayHasKey('subject', $data['data']['emails'][0]);
        $this->assertArrayHasKey('body', $data['data']['emails'][0]);
    }
}
