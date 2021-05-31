<?php

declare(strict_types=1);

namespace App\Client;

use App\Exception\ExternalApiException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use JetBrains\PhpStorm\Pure;
use Zend\Json\Json;

/**
 * Class BlockchairApiClient
 * @package App\Client
 */
class BlockchairApiClient extends RestApiClient
{
    /**
     * @param string $baseUrl
     * @param GuzzleClient $client
     */
    #[Pure]
    public function __construct(string $baseUrl, GuzzleClient $client)
    {
        parent::__construct($baseUrl, $client);
    }

    /**
     * @inheritDoc
     */
    public function send(int $number): array
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

        return Json::decode($response->getBody()->getContents(), Json::TYPE_ARRAY);
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
