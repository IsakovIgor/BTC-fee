<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class ExternalApi
 * @package App\Service\ExternalApi
 */
abstract class ExternalApi implements ExternalApiInterface
{
    private string $baseUrl;
    private ClientInterface $client;
    private DenormalizerInterface $denormalizer;

    /**
     * @param string $baseUrl
     * @param ClientInterface $client
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(string $baseUrl, ClientInterface $client, DenormalizerInterface $denormalizer)
    {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @inheritDoc
     */
    abstract public function getLastBlocks(int $number = 100): array;

    /**
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @return DenormalizerInterface
     */
    protected function getSerializer(): DenormalizerInterface
    {
        return $this->denormalizer;
    }
}
