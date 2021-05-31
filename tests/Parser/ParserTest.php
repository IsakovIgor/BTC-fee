<?php

declare(strict_types=1);

namespace App\Tests\Parser;

use App\Exception\ParseExternalApiException;
use App\Parser\BlockchairParser;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class ParserTest
 * @package App\Tests\Parser
 */
class ParserTest extends TestCase
{
    use ProphecyTrait;

    private const MODEL = 'model';

    /**
     * @group parser
     *
     * @param array $data
     * @param string $key
     * @param bool $exception
     * @throws ExceptionInterface
     * @dataProvider getData
     */
    public function testParse(array $data, string $key, bool $exception)
    {
        /** @var DenormalizerInterface|ObjectProphecy $denormalizer */
        $denormalizer = $this->prophesize(DenormalizerInterface::class);
        $denormalizer->denormalize($data[$key], self::MODEL, BlockchairParser::DENORMALIZER_FORMAT)
            ->willReturn([]);

        if ($exception) {
            $this->expectException(ParseExternalApiException::class);
        }

        $parser = new BlockchairParser($denormalizer->reveal());
        $this->assertEquals($parser->parse($data, self::MODEL), []);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'data'      => ['something' => []],
                'key'       => 'something',
                'exception' => true,
            ],
            [
                'data'      => ['data' => []],
                'key'       => 'data',
                'exception' => false,
            ]
        ];
    }
}
