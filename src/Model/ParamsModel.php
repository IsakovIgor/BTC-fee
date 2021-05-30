<?php

declare(strict_types=1);

namespace App\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Class ParamsModel
 * @package App\Model
 */
class ParamsModel
{
    private string $min;
    private string $max;
    private string $sum;
    private string $totalItems;

    /**
     * @return string
     */
    public function getMin(): string
    {
        return $this->min;
    }

    /**
     * @param string $min
     * @return ParamsModel
     */
    public function setMin(string $min): self
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return string
     */
    public function getMax(): string
    {
        return $this->max;
    }

    /**
     * @param string $max
     * @return ParamsModel
     */
    public function setMax(string $max): self
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return string
     */
    public function getSum(): string
    {
        return $this->sum;
    }

    /**
     * @param string $sum
     * @return ParamsModel
     */
    public function setSum(string $sum): self
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalItems(): string
    {
        return $this->totalItems;
    }

    /**
     * @param string $totalItems
     * @return ParamsModel
     */
    public function setTotalItems(string $totalItems): self
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    /**
     * @return string
     */
    #[Pure]
    public function getAvg(): string
    {
        return bcdiv($this->getSum(), $this->getTotalItems(), 2);
    }
}
