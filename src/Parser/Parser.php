<?php

declare(strict_types=1);

namespace App\Parser;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class Parser
 * @package App\Parser
 */
abstract class Parser implements ParserInterface
{
    private DenormalizerInterface $denormalizer;

    /**
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * @return DenormalizerInterface
     */
    protected function getDenormalizer(): DenormalizerInterface
    {
        return $this->denormalizer;
    }
}
