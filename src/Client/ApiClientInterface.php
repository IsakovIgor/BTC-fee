<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Interface ApiClientInterface
 * @package App\Client
 */
interface ApiClientInterface
{
    /**
     * @param int $number
     * @return array
     * @throws GuzzleException
     */
    public function send(int $number): array;
}
