<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

use App\Exception\ExternalApiException;
use App\Exception\ParseExternalApiException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class BlockchairApi
 * @package App\Service\ExternalApi
 */
class BlockchairApi extends ExternalApi
{
    /**
     * @param string $baseUrl
     * @param ClientInterface $client
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(string $baseUrl, ClientInterface $client, DenormalizerInterface $denormalizer)
    {
        parent::__construct($baseUrl, $client, $denormalizer);
    }

    /**
     * @param int $number
     * @return array
     * @throws GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getLastBlocks(int $number = 100): array
    {
        $query = $this->createQuery([
            's'     => 'time(desc)',
            'limit' => $number,
        ]);

        $request = new Request('GET', $query);

        $response = $this->getClient()->send($request);
        if ($response->getStatusCode() !== 200) {
            throw new ExternalApiException(
                \sprintf(
                    'Error while sending request to external api %s. Received code is %d',
                    $query,
                    $response->getStatusCode())
            );
        }

        $content = $response->getBody()->getContents();
        $data = \json_decode($content, true);

        if (!isset($data['data'])) {
            throw new ParseExternalApiException(
                \sprintf('There are no "data" key in response array from %s', $query)
            );
        }

        return $this->getSerializer()->denormalize($data['data'], 'App\Model\BlockchairModel[]', 'json');
    }

    /**
     * @param array $params
     * @return string
     */
    #[Pure]
    private function createQuery(array $params = []): string
    {
        return $this->getBaseUrl() . '?' . http_build_query($params);
    }
}
