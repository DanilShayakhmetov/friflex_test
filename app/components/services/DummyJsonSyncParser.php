<?php

namespace app\components\services;

use app\models\Product;
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

    public function sync(array $data): int
    {
        $count = 0;
        foreach ($data as $item) {
            $product = Product::findOne(['id' => $item['id']]) ?: new Product(['id' => $item['id']]);
            $product->name = $item['title'];
            $product->price = $item['price'];
            $product->description = $item['description'];
            if ($product->save(false)) {
                $count++;
            }
        }

        return $count;
    }
}
