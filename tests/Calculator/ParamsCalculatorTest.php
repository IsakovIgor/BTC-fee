<?php

declare(strict_types=1);

namespace App\Tests\Calculator;

use App\Calculator\ParamsCalculatorTrait;
use App\Model\BlockchairModel;
use App\Model\ParamsModel;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Class ParamsCalculatorTest
 * @package App\Tests\Calculator
 */
class ParamsCalculatorTest extends TestCase
{
    use ProphecyTrait;

    private const MODEL = 'model';

    /**
     * @group calculator
     *
     * @param array $models
     * @param ParamsModel $result
     * @dataProvider getData
     */
    public function testParse(array $models, ParamsModel $result)
    {
        /** @var ParamsCalculatorTrait|MockObject $traitMock */
        $traitMock = $this->getMockBuilder(ParamsCalculatorTrait::class)->getMockForTrait();
        $this->assertEquals($traitMock->calculateParams($models), $result);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'models' => [
                    (new BlockchairModel())->setFeeTotal('1'),
                    (new BlockchairModel())->setFeeTotal('2'),
                    (new BlockchairModel())->setFeeTotal('3'),
                    (new BlockchairModel())->setFeeTotal('4'),
                    (new BlockchairModel())->setFeeTotal('5'),
                ],
                'result' => (new ParamsModel())
                    ->setMin('1')
                    ->setMax('5')
                    ->setSum('15')
                    ->setTotalItems('5'),
            ],
            [
                'models' => [
                    (new BlockchairModel())->setFeeTotal('3'),
                    (new BlockchairModel())->setFeeTotal('5'),
                    (new BlockchairModel())->setFeeTotal('4'),
                    (new BlockchairModel())->setFeeTotal('1'),
                    (new BlockchairModel())->setFeeTotal('2'),
                ],
                'result' => (new ParamsModel())
                    ->setMin('1')
                    ->setMax('5')
                    ->setSum('15')
                    ->setTotalItems('5'),
            ],
        ];
    }
}
