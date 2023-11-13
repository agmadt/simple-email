<?php

namespace App\Utilities\Contracts;

use App\Mail\SendEmail;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param  SendMail  $mail
     * @return void
     */
    public function storeEmail(SendEmail $mail): void;

    /**
     * List all email inside elasticsearch.
     *
     * @param  string  $page
     * @param  string  $perPage
     * @return mixed - Return results from Elasticsearch
     */
    public function listEmail(string $page, string $perPage): array;
}
