<?php

namespace App\Utilities\Contracts;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param  string  $messageBody
     * @param  string  $messageSubject
     * @param  string  $toEmailAddress
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(string $messageBody, string $messageSubject, string $toEmailAddress): mixed;

    /**
     * List all email inside elasticsearch.
     *
     * @param  string  $page
     * @param  string  $perPage
     * @return mixed - Return results from Elasticsearch
     */
    public function listEmail(string $page, string $perPage): array;
}
