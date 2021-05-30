<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Model\ExternalSourceInterface;
use App\Model\ParamsModel;

/**
 * Class ParamsCalculator
 * @package App\Calculator
 */
class ParamsCalculator
{
    /**
     * Find min, max, sum and number of items
     *
     * @param ExternalSourceInterface[] $models
     * @return ParamsModel
     */
    public static function calculateParams(array $models): ParamsModel
    {
        return \array_reduce($models, function(?ParamsModel $params, ExternalSourceInterface $m) {
            $data = $m->getDataForParams();

            if ($params === null) {
                return (new ParamsModel())
                    ->setMin($data['fee'])
                    ->setMax($data['fee'])
                    ->setSum($data['fee'])
                    ->setTotalItems('1');
            }

            return (new ParamsModel())
                ->setMin($params->getMin() <= $data['fee'] ? $params->getMin() : $data['fee'])
                ->setMax($params->getMax() >= $data['fee'] ? $params->getMax() : $data['fee'])
                ->setSum(\bcadd($params->getSum(), $data['fee']))
                ->setTotalItems(\bcadd($params->getTotalItems(), '1'));
        });
    }
}
