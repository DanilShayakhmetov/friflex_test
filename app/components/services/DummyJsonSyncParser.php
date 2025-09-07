<?php

namespace app\components\services;

use yii\httpclient\Client;

class DummyJsonSyncParser implements ParserInterface
{
    private Client $client;
    private string $baseUrl;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client();
        $this->baseUrl = 'https://dummyjson.com/';
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function fetchData(): array
    {
        $response = $this->client->get($this->baseUrl . 'products')->send();

        if (!$response->isOk) {
            return [];
        }

        return $response->data['products'] ?? [];
    }
}
