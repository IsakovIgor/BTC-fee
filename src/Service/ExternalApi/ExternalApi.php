<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use App\Client\ApiClientInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class ExternalApi
 * @package App\Service\ExternalApi
 */
abstract class ExternalApi implements ExternalApiInterface
{
    private ApiClientInterface $client;
    private DenormalizerInterface $denormalizer;

    /**
     * @param ApiClientInterface $client
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(ApiClientInterface $client, DenormalizerInterface $denormalizer)
    {
        $this->client = $client;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @inheritDoc
     */
    abstract public function getLastBlocks(int $number = 100): array;

    /**
     * @return ApiClientInterface
     */
    protected function getClient(): ApiClientInterface
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
