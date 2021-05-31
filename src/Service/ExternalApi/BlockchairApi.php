<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use App\Client\ApiClientInterface;
use App\Exception\ParseExternalApiException;
use App\Parser\ParserInterface;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;

/**
 * Class BlockchairApi
 * @package App\Service\ExternalApi
 */
class BlockchairApi extends ExternalApi
{
    private const MODEL = 'App\Model\BlockchairModel[]';

    /**
     * @param ApiClientInterface $client
     * @param ParserInterface $parser
     */
    #[Pure]
    public function __construct(ApiClientInterface $client, ParserInterface $parser)
    {
        parent::__construct($client, $parser);
    }

    /**
     * @param int $number
     * @return array
     * @throws GuzzleException|ParseExternalApiException
     */
    public function getLastBlocks(int $number = 100): array
    {
        $data = $this->getClient()->send($number);
        return $this->getParser()->parse($data, self::MODEL);
    }
}
