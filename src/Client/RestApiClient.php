<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class ApiClient
 * @package App\Client
 */
abstract class RestApiClient implements ApiClientInterface
{
    private string $baseUrl;
    private GuzzleClient $client;

    /**
     * @param string $baseUrl
     * @param GuzzleClient $client
     */
    public function __construct(string $baseUrl, GuzzleClient $client)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
    }

    /**
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return GuzzleClient
     */
    protected function getClient(): GuzzleClient
    {
        return $this->client;
    }
}
