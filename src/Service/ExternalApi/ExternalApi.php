<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use App\Client\ApiClientInterface;
use App\Parser\ParserInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class ExternalApi
 * @package App\Service\ExternalApi
 */
abstract class ExternalApi implements ExternalApiInterface
{
    private ApiClientInterface $client;
    private ParserInterface $parser;

    /**
     * @param ApiClientInterface $client
     * @param ParserInterface $parser
     */
    public function __construct(ApiClientInterface $client, ParserInterface $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
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
     * @return ParserInterface
     */
    protected function getParser(): ParserInterface
    {
        return $this->parser;
    }
}
