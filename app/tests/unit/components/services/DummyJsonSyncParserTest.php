<?php

namespace app\tests\unit\components\services;

use PHPUnit\Framework\TestCase;
use app\components\services\DummyJsonSyncParser;
use yii\httpclient\Client;

class DummyJsonSyncParserTest extends TestCase
{
    public function testFetchDataReturnsProducts()
    {
        $mockResponse = (object)[
            'data' => [
                'products' => [
                    [
                        'id' => 1,
                        'title' => 'Test Product',
                        'price' => 99.9,
                        'description' => 'Test description',
                    ]
                ]
            ],
            'isOk' => true,
        ];

        $mockClient = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();

        $mockRequest = new class($mockResponse) {
            private $resp;
            public function __construct($resp) { $this->resp = $resp; }
            public function send() { return $this->resp; }
        };

        $mockClient->method('get')->willReturn($mockRequest);

        $service = new DummyJsonSyncParser($mockClient);
        $products = $service->fetchData();

        $this->assertCount(1, $products);
        $this->assertEquals('Test Product', $products[0]['title']);
    }
}


