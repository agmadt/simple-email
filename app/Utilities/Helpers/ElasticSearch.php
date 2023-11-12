<?php

namespace App\Utilities\Helpers;

use Illuminate\Support\Str;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Carbon\Carbon;
use MailerLite\LaravelElasticsearch\Facade as MailerLiteElasticSearch;

class ElasticSearch implements ElasticsearchHelperInterface
{
    function storeEmail(string $messageBody, string $messageSubject, string $toEmailAddress): mixed
    {
        $data = [
            'index' => 'simple-email',
            'id' => (string) Str::ulid(),
            'type' => '_doc',
            'body' => [
                'email' => $toEmailAddress,
                'subject' => $messageSubject,
                'body' => $messageBody,
                'created_at' => Carbon::now()
            ]
        ];

        return MailerLiteElasticSearch::index($data);
    }
}
