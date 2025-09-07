<?php


require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use app\components\services\DummyJsonSyncParser;

final class AutoloadTest extends TestCase
{
    public function testClassExists(): void
    {
        $this->assertTrue(class_exists(DummyJsonSyncParser::class));
    }
}
