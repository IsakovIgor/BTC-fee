<?php

declare(strict_types=1);

namespace App\Tests\Service\ExternalApi;

use App\Client\ApiClientInterface;
use App\Parser\ParserInterface;
use App\Service\ExternalApi\BlockchairApi;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class BlockchairApiTest
 * @package App\Tests\Service\ExternalApi
 */
class BlockchairApiTest extends TestCase
{
    use ProphecyTrait;

    private const NUMBER = 100;

    private const MODEL = 'model';

    /**
     * @group external_api
     *
     * @param array $data
     * @param array $result
     * @throws GuzzleException
     * @dataProvider getData
     */
    public function testGetLastBlocks(array $data, array $result)
    {
        /** @var ApiClientInterface|ObjectProphecy $apiClient */
        $apiClient = $this->prophesize(ApiClientInterface::class);
        $apiClient->send(self::NUMBER)->willReturn($data);

        /** @var ParserInterface|ObjectProphecy $parser */
        $parser = $this->prophesize(ParserInterface::class);
        $parser->parse($data, BlockchairApi::MODEL)->willReturn($result);

        $api = new BlockchairApi($apiClient->reveal(), $parser->reveal());
        $this->assertEquals($api->getLastBlocks(self::NUMBER), $result);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'data'   => ['something' => []],
                'result' => ['something' => []],
            ],
            [
                'data'   => ['data' => []],
                'result' => ['data' => []],
            ]
        ];
    }
}
