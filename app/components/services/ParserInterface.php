<?php


namespace app\components\services;

interface ParserInterface
{
    /**
     *
     * @param string $json
     * @return array
     * @throws \JsonException
     */
    public function fetchData(): array;
}
