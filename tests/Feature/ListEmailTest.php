<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        
        $response = $this->getJson('/api/list?api_token=' . $apiToken);
        $response->assertStatus(200);

        $data = $response->json();
        $this->assertArrayHasKey('emails', $data['data']);
        $this->assertArrayHasKey('email', $data['data']['emails'][0]);
        $this->assertArrayHasKey('subject', $data['data']['emails'][0]);
        $this->assertArrayHasKey('body', $data['data']['emails'][0]);
    }
}
