<?php

namespace App\Utilities\Helpers;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Carbon\Carbon;
use MailerLite\LaravelElasticsearch\Facade as MailerLiteElasticSearch;

class ElasticSearch implements ElasticsearchHelperInterface
{
    function storeEmail(string $mailID, string $messageBody, string $messageSubject, string $toEmailAddress): mixed
    {
        $data = [
            'index' => 'simple-email',
            'id' => $mailID,
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

    function listEmail(string $page, string $perPage): array
    {
        $params = [
            'index' => 'simple-email',
            'body' => [
                'from' => ($page - 1) * $perPage,
                'size' => $perPage,
            ]
        ];

        $response = MailerLiteElasticSearch::search($params);
        $emails = [];
        
        foreach ($response['hits']['hits'] as $hit) {
            $emails[] = [
                'id' => $hit['_id'],
                'email' => $hit['_source']['email'],
                'subject' => $hit['_source']['subject'],
                'body' => $hit['_source']['body'],
            ];
        }

        return [
            'emails' => $emails,
            'total' => $response['hits']['total']['value'],
            'page' => $page,
            'per_page' => $perPage,
        ];
    }
}
