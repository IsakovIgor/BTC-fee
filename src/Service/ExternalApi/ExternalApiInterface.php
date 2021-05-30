<?php

declare(strict_types=1);

namespace App\Service\ExternalApi;

/**
 * Interface ExternalApiInterface
 * @package App\Service\ExternalApi
 */
interface ExternalApiInterface
{
    /**
     * @param int $number
     * @return array
     */
    public function getLastBlocks(int $number = 100): array;
}
