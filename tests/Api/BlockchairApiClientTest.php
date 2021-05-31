<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Client\BlockchairApiClient;
use App\Exception\ExternalApiException;
use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Json\Json;

/**
 * Class BlockchairApiClientTest
 * @package App\Tests\Api
 */
class BlockchairApiClientTest extends TestCase
{
    use ProphecyTrait;

    private const BASE_URL = 'baseUrl';
    private const NUMBER = 100;

    /**
     * @group api_client
     *
     * @param int $httpCode
     * @param string $encodedArray
     * @param bool $exception
     * @throws GuzzleException
     * @throws \ReflectionException
     * @dataProvider getData
     */
    public function testSend(int $httpCode, string $encodedArray, bool $exception)
    {
        $query = $this->getQueryByReflection();
        $request = new Request(BlockchairApiClient::HTTP_METHOD, $this->getQueryByReflection());

        /** @var StreamInterface|ObjectProphecy $body */
        $body = $this->prophesize(StreamInterface::class);
        $body->getContents()->willReturn($encodedArray);

        /** @var ResponseInterface|ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getStatusCode()->willReturn($httpCode);
        $response->getBody()->willReturn($body->reveal());

        /** @var GuzzleHttp|ObjectProphecy $guzzleClient */
        $guzzleClient = $this->prophesize(GuzzleHttp::class);
        $guzzleClient->send($request)->willReturn($response->reveal());

        if ($exception) {
            $this->expectException(ExternalApiException::class);
        }

        $client = new BlockchairApiClient(self::BASE_URL, $guzzleClient->reveal());
        $this->assertEquals($client->send(self::NUMBER), Json::decode($encodedArray, Json::TYPE_ARRAY));
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'httpCode'     => 200,
                'encodedArray' => '{"data":"data"}',
                'exception'    => false,
            ],
            [
                'httpCode'     => 500,
                'encodedArray' => '',
                'exception'    => true,
            ]
        ];
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    private function getQueryByReflection(): string
    {
        /** @var BlockchairApiClient|\ReflectionClass $class */
        $class = new \ReflectionClass(BlockchairApiClient::class);
        $method = $class->getMethod('createQuery');
        $method->setAccessible(true);

        /** @var GuzzleHttp|ObjectProphecy $guzzle */
        $guzzle = $this->prophesize(GuzzleHttp::class);
        $object = new BlockchairApiClient(self::BASE_URL, $guzzle->reveal());

        return $method->invokeArgs($object, [
            [
                's'     => 'time(desc)',
                'limit' => self::NUMBER,
            ]
        ]);
    }
}
