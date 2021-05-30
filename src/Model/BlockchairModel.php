<?php

declare(strict_types=1);

namespace App\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Class BlockchairModel
 * @package App\Model
 */
class BlockchairModel implements ExternalSourceInterface
{
    private int $id;
    private string $hash;
    private \DateTime $time;
    private string $feeTotal;
    private string $feeTotalUsd;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BlockchairModel
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return BlockchairModel
     */
    public function setHash(string $hash): self
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    public function getTimeFormatted(string $format = 'd.m.Y H:i:s'): string
    {
        return $this->time->format($format);
    }

    /**
     * @param \DateTime $time
     * @return BlockchairModel
     */
    public function setTime(\DateTime $time): self
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeeTotal(): string
    {
        return $this->feeTotal;
    }

    /**
     * @return string
     */
    #[Pure]
    public function getFee(): string
    {
        return $this->getFeeTotal();
    }

    /**
     * @param string $feeTotal
     * @return BlockchairModel
     */
    public function setFeeTotal(string $feeTotal): self
    {
        $this->feeTotal = $feeTotal;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeeTotalUsd(): string
    {
        return $this->feeTotalUsd;
    }

    /**
     * @param string $feeTotalUsd
     * @return BlockchairModel
     */
    public function setFeeTotalUsd(string $feeTotalUsd): self
    {
        $this->feeTotalUsd = $feeTotalUsd;
        return $this;
    }

    /**
     * @inheritDoc
     * @see ExternalSourceInterface::getDataForParams() for details
     */
    #[Pure]
    public function getDataForParams(): array
    {
        return [
            'fee' => $this->getFeeTotal(),
        ];
    }
}
