<?php


namespace app\components\services;

interface ParserInterface
{
    /**
     * @return array
     * @throws \JsonException
     */
    public function fetchData(): array;

    /**
     *
     * @param array $data
     * @return int
     */
    public function sync(array $data): int;
}
