<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use App\Client\ApiClientInterface;
use App\Exception\ParseExternalApiException;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Zend\Json\Json;

/**
 * Class BlockchairApi
 * @package App\Service\ExternalApi
 */
class BlockchairApi extends ExternalApi
{
    /**
     * @param ApiClientInterface $client
     * @param DenormalizerInterface $denormalizer
     */
    #[Pure]
    public function __construct(ApiClientInterface $client, DenormalizerInterface $denormalizer)
    {
        parent::__construct($client, $denormalizer);
    }

    /**
     * @param int $number
     * @return array
     * @throws ExceptionInterface|GuzzleException
     */
    public function getLastBlocks(int $number = 100): array
    {
        $data = $this->getClient()->send($number);

        if (!isset($data['data'])) {
            throw new ParseExternalApiException(
                \sprintf('There are no "data" key in response array from %s', Json::encode($data))
            );
        }

        return $this->getSerializer()->denormalize($data['data'], 'App\Model\BlockchairModel[]', 'json');
    }
}
