<?php

declare(strict_types=1);

namespace App\Parser;

use App\Exception\ParseExternalApiException;

/**
 * Interface ParserInterface
 * @package App\Parser
 */
interface ParserInterface
{
    /**
     * @param array $data
     * @param string $model
     * @return array
     * @throws ParseExternalApiException
     */
    public function parse(array $data, string $model): array;
}
