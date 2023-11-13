<?php

namespace App\Utilities\Helpers;

use App\Mail\SendEmail;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Carbon\Carbon;
use MailerLite\LaravelElasticsearch\Facade as MailerLiteElasticSearch;

class ElasticSearch implements ElasticsearchHelperInterface
{
    function storeEmail(SendEmail $mail): void
    {
        $data = [
            'index' => 'simple-email',
            'id' => $mail->id,
            'type' => '_doc',
            'body' => [
                'email' => $mail->email,
                'subject' => $mail->subject,
                'body' => $mail->body,
                'user_name' => $mail->user_name,
                'user_email' => $mail->user_email,
                'created_at' => Carbon::now()
            ]
        ];

        MailerLiteElasticSearch::index($data);
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
                'user_name' => $hit['_source']['user_name'],
                'user_email' => $hit['_source']['user_email'],
                'created_at' => $hit['_source']['created_at'],
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
