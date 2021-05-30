<?php

declare(strict_types=1);

namespace App\Model;

use App\Calculator\ParamsCalculator;

/**
 * Interface ExternalSourceInterface
 * @package App\Model
 */
interface ExternalSourceInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getFee(): string;

    /**
     * common interface for ParamsCalculator
     * @see ParamsCalculator
     *
     * @return array<string>
     */
    public function getDataForParams(): array;
}
